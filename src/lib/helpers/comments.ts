import toast from 'svelte-french-toast';
import { tick } from 'svelte';
import { t } from '$lib/translations';

export const commentMassage = {
	add: {
		loading: t.get('global.comment.add.loading'),
		success: t.get('global.comment.add.success'),
		error: t.get('global.comment.add.error')
	},
	delete: {
		loading: t.get('global.comment.delete.loading'),
		success: t.get('global.comment.delete.success'),
		error: t.get('global.comment.delete.error')
	},
	edit: {
		loading: t.get('global.comment.add.loading'),
		success: t.get('global.comment.edit.success'),
		error: t.get('global.comment.edit.error')
	}
};

export function сommentValidations(value: string) {
	value = value.trim();
	toast.dismiss();
	if (!value) {
		toast.error('Comment cannot be empty');
		return;
	}
	if (value.length <= 2) {
		toast.error('Comment cannot be longer than 3 characters');
		return;
	}
	return true;
}

export async function scrollToBottom(id: string) {
	await tick();
	const element = document.getElementById(id);
	const rect = element?.getBoundingClientRect();

	if (rect && rect.bottom > window.innerHeight) {
		element?.scrollIntoView({ behavior: 'instant', block: 'end', inline: 'nearest' });
	}
}
