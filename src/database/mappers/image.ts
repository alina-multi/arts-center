import type { Image } from '$lib/interfaces/Image';
import type { images } from '@prisma/client';
import { PUBLIC_IMAGE_HOST } from '$env/static/public';

export function imageMap(image: images | null): Image | null {
	if (image === null) return null;
	if (PUBLIC_IMAGE_HOST === undefined) {
		return {
			src: 'https://picsum.photos/300/225',
			srcset: 'https://picsum.photos/300/225 300w, https://picsum.photos/600/450 600w'
		};
	}
	let srcset = [];
	for (let width of [300, 600, 1200, 2400]) {
		if (image[`w${width}`]) {
			for (let extention of ['jpg', 'webp']) {
				srcset.push(`${getUrl(image, width, extention)} ${width}w`);
			}
		}
	}

	return {
		src: getUrl(image),
		srcset: srcset.join(', ')
	};
}

function getUrl(image: images, width: number = 0, extention: 'jpg' | 'webp' = 'jpg'): string {
	let url = `${PUBLIC_IMAGE_HOST}/${image.folder}/${image.name}`;
	if (width) {
		url += `-w${width}`;
	}
	return `${url}.${extention}`;
}
