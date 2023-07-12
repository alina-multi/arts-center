import { describe, expect, it, test, vi } from 'vitest';
import { pictureMap } from './pictures';

const image = {
	folder: 'preview',
	variants: [
		{
			id: 1,
			width: 300,
			height: 250,
			extension: 'jpeg',
			original: 0
		},
		{
			id: 5,
			width: 1280,
			height: 1024,
			extension: 'jpeg',
			original: 1
		},
		{
			id: 4,
			width: 600,
			height: 500,
			extension: 'webp',
			original: 0
		},
		{
			id: 3,
			width: 600,
			height: 500,
			extension: 'jpeg',
			original: 0
		},
		{
			id: 2,
			width: 300,
			height: 250,
			extension: 'webp',
			original: 0
		}
	]
};

describe('pictureMap converts from sources', () => {
	test('that it groups by extension and has valid src', () => {
		vi.stubEnv('PUBLIC_IMAGE_HOST', 'https://i.arts.center');
		const result = pictureMap(image);
		expect(result).toStrictEqual({
			src: 'https://i.arts.center/preview/1.jpeg',
			sources: [
				{
					type: 'image/webp',
					srcset:
						'https://i.arts.center/preview/2.webp 300w, https://i.arts.center/preview/4.webp 600w'
				},
				{
					type: 'image/jpeg',
					srcset:
						'https://i.arts.center/preview/1.jpeg 300w, https://i.arts.center/preview/3.jpeg 600w'
				}
			],
			original: {
				src: 'https://i.arts.center/preview/5.jpeg',
				width: 1280,
				height: 1024
			}
		});
		vi.unstubAllEnvs();
	});
});
