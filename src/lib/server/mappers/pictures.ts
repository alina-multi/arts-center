import type { Picture } from '$lib/interfaces/Picture';
import type { images, image_variants, imageables } from '@prisma/client';

type ImageFolder = 'preview' | 'works' | 'photos' | 'grids';

interface imageWithRelation extends images {
	variants: image_variants[];
}

export function picturesMap(images: imageWithRelation[]): Picture[] {
	return images?.map((image) => pictureMap(image));
}

export function imagablePicturesMap(images: imageables[]): Picture[] {
	return images?.map((image) => pictureMap(image?.image));
}

export function pictureMap(image: imageWithRelation): Picture {
	const sourcesMap: Map<string, { type: string; srcset: string[] }> = new Map();
	if (!image.variants) {
		return {
			original: {
				src: '',
				width: 0,
				height: 0
			},
			sources: [],
			src: ''
		};
	}
	const sortedVariants = image.variants.sort((a, b) => a.width - b.width);
	let original, src;
	for (let variant of sortedVariants) {
		if (variant.original) {
			original = {
				src: buildSrc(image.folder, variant.id, variant.extension),
				width: variant.width,
				height: variant.height
			};
			continue;
		}
		if (!src && variant.extension !== 'webp') {
			src = buildSrc(image.folder, variant.id, variant.extension);
		}
		const type = `image/${variant.extension}`;
		const source = sourcesMap.get(type) ?? {
			type,
			srcset: []
		};
		const url = buildSrc(image.folder as ImageFolder, variant.id, variant.extension);
		source.srcset.push(`${url} ${variant.width}w`);
		sourcesMap.set(type, source);
	}
	const sources = [];
	for (let type of Array.from(sourcesMap.keys()).sort().reverse()) {
		const source = sourcesMap.get(type);
		sources.push({
			type,
			srcset: source?.srcset.join(', ')
		});
	}
	return {
		original,
		sources,
		src
	};
}

function buildSrc(folder: ImageFolder, id: bigint, extension: string): string {
	const host = process.env.PUBLIC_IMAGE_HOST;
	if (host) {
		return `${host}/${folder}/${id.toString()}.${extension}`;
	}
	return `https://picsum.photos/id/${id.toString()}/600/400`;
}
