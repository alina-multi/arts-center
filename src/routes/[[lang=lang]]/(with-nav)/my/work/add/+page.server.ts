import type { PageServerLoad, Actions } from './$types';
import { api } from '$lib/server/api';
import { locale, localePath } from "$lib/translations";
import { uploadFile } from '$lib/server/s3';
import { error, redirect } from '@sveltejs/kit';
import { getCategories } from '$lib/server/repositories/tag';
import { tagsMap } from '$lib/server/mappers/tag';

export const load = (async (event) => {
	return {};
}) satisfies PageServerLoad;

export const actions = {
	default: async (event) => {
		const form = await event.request.formData();
		const errors = {
			upload: []
		};
		const folder = Date.now();
		const imagePaths = await Promise.all(
			[form.get('main'), ...form.getAll('more')]
				.filter((image) => validate(image, errors))
				.map((image) => upload(image, folder))
		);
		const response = await api({
			method: 'POST',
			path: '/api2/draft',
			event,
			data: {
				main: imagePaths[0],
				more: imagePaths.slice(1),
				language: locale.get()
			}
		});
		if (!response.ok) {
			throw error(response.status, await response.text());
		}
		const { id } = await response.json();
		throw redirect(302, localePath(`/my/work/draft/${id}`));
	}
} satisfies Actions;

async function upload(image: File, folder: string) {
	const key = `temp/works/${folder}/${Math.random()}.${image?.type.split('/').pop()}`;
	await uploadFile(image, key);
	return key;
}

function validate(image: File, errors) {
	if (image.type.split('/')[0] !== 'image') {
		errors.upload.push(`File ${image.name} is not an image`);
		return false;
	}
	// 10Mb
	if (image.size > 1e7) {
		errors.upload.push(`File ${image.name} too large`);
		return false;
	}
	return true;
}
