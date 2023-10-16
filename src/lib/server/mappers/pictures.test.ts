import { describe, expect, test, vi } from 'vitest';
import { pictureMap, picturesMap, imagablePicturesMap } from './pictures';
import { image_raw_data } from '$test/data/PictureData';

describe('pictureMap converts from sources', () => {
	test('test if we only have original', () => {
		vi.stubEnv('PUBLIC_IMAGE_HOST', 'https://i.arts.center');
		const result = pictureMap({
			id: 11n,
			folder: 'preview',
			variants: [
				{
					id: 11n,
					width: 500,
					height: 428,
					extension: 'jpeg',
					original: true,
					size: 0
				}
			]
		});
		expect(result).toStrictEqual({
			src: 'https://i.arts.center/preview/11.jpeg',
			sources: [],
			original: {
				src: 'https://i.arts.center/preview/11.jpeg',
				width: 500,
				height: 428
			}
		});
		vi.unstubAllEnvs();
	});
	test('that it groups by extension and has valid src', () => {
		vi.stubEnv('PUBLIC_IMAGE_HOST', 'https://i.arts.center');
		const result = pictureMap(image_raw_data);
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

test('imagablePicturesMap', () => {
	const pictures = [{ image: { ...image_raw_data, variants: [] } }, { image: image_raw_data }];
	const result = imagablePicturesMap(pictures);
	expect(result).toMatchInlineSnapshot(`
		[
		  {
		    "original": {
		      "height": 1024,
		      "src": "https://picsum.photos/id/5/400/600",
		      "width": 1280,
		    },
		    "sources": [
		      {
		        "srcset": "https://picsum.photos/id/2/400/600 300w, https://picsum.photos/id/4/400/600 600w",
		        "type": "image/webp",
		      },
		      {
		        "srcset": "https://picsum.photos/id/1/400/600 300w, https://picsum.photos/id/3/400/600 600w",
		        "type": "image/jpeg",
		      },
		    ],
		    "src": "https://picsum.photos/id/1/400/600",
		  },
		]
	`);
});

test('picturesMap', () => {
	const pictures = [{ ...image_raw_data, variants: [] }, image_raw_data];
	const result = picturesMap(pictures);
	expect(result).toMatchInlineSnapshot(`
		[
		  {
		    "original": {
		      "height": 1024,
		      "src": "https://picsum.photos/id/5/400/600",
		      "width": 1280,
		    },
		    "sources": [
		      {
		        "srcset": "https://picsum.photos/id/2/400/600 300w, https://picsum.photos/id/4/400/600 600w",
		        "type": "image/webp",
		      },
		      {
		        "srcset": "https://picsum.photos/id/1/400/600 300w, https://picsum.photos/id/3/400/600 600w",
		        "type": "image/jpeg",
		      },
		    ],
		    "src": "https://picsum.photos/id/1/400/600",
		  },
		]
	`);
});
