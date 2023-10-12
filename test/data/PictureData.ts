import type { Picture } from '$lib/interfaces/Picture';
import type { image_raw } from '$lib/server/repositories/image';


export const image_raw_data = {
	id: 11n,
	folder: 'preview',
	variants: [
		{
			id: 1n,
			width: 300,
			height: 250,
			extension: 'jpeg',
			original: false,
			size: 67558
		},
		{
			id: 5n,
			width: 1280,
			height: 1024,
			extension: 'jpeg',
			original: true,
			size: 67558
		},
		{
			id: 4n,
			width: 600,
			height: 500,
			extension: 'webp',
			original: false,
			size: 0,
		},
		{
			id: 3n,
			width: 600,
			height: 500,
			extension: 'jpeg',
			original: false,
			size: 0
		},
		{
			id: 2n,
			width: 300,
			height: 250,
			extension: 'webp',
			original: false,
			size: 0
		}
	]
} satisfies image_raw;


export default {
	src: '',
	sources: [
		{
			type: '',
			srcset: ''
		}
	],
	original: {
		src: '',
		width: 600,
		height: 400
	}
} as Picture;
