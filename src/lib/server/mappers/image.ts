import type { Image } from '$lib/interfaces/Image';
import type { imageables, images } from '@prisma/client';
import { PUBLIC_IMAGE_HOST } from '$env/static/public';

export type imageablesWithRelations = imageables & {
	image: images;
};
export function imagesMap(images: imageablesWithRelations[]): Image[] | undefined {
	return images?.map((image) => imageMap(image.image));
}
export function imageMap(image: images): Image {
	if (!image) {
		return {
			src: '',
			srcset: ''
		};
	}
	if (!PUBLIC_IMAGE_HOST) {
		const heights = [450, 600, 1200];
		const height = heights[Math.floor(Math.random() * heights.length)];
		return {
			src: `https://picsum.photos/id/${image.id}/600/${height}`,
			srcset: ``
		};
	}
	const srcset = [];
	for (const width of [300, 600, 1200, 2400]) {
		if (image[`w${width}`]) {
			for (const extention of ['webp', 'jpg']) {
				srcset.push(`${getUrl(image, width, extention)} ${width}w`);
			}
		}
	}

	return {
		src: getUrl(image),
		srcset: srcset.join(', ')
	};
}

function getUrl(image: images, width = 0, extention: 'jpg' | 'webp' = 'jpg'): string {
	let url = `${PUBLIC_IMAGE_HOST}/${image.folder}/${image.name}`;
	if (width) {
		url += `-w${width}`;
	}
	return `${url}.${extention}`;
}
