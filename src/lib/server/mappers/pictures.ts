import type { Picture } from '$lib/interfaces/Picture';
import type { image_raw } from '../repositories/image';
import type { ImageFolder } from '../repositories/image';

type ImageWithRelations = {
	image: image_raw;
};

export function picturesMap(images: image_raw[] | []): Picture[] | [] {
	return images
		.filter((image) => image && image.variants && image.variants.length)
		?.map((image) => pictureMap(image));
}

export function imagablePicturesMap(images: ImageWithRelations[] | []): Picture[] | [] {
	return images
		.filter((image) => image.image?.variants?.length > 0)
		?.map((image) => pictureMap(image.image));
}

export function pictureMap(image: image_raw | null): Picture | null {
	const sourcesMap: Map<string, { type: string; srcset: string[] }> = new Map();
	if (!image || !image.variants) {
		return null;
	}
	const sortedVariants = image.variants.sort((a, b) => a.width - b.width);
	let original, src;
	for (const variant of sortedVariants) {
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
		const url = buildSrc(image.folder, variant.id, variant.extension);
		source.srcset.push(`${url} ${variant.width}w`);
		sourcesMap.set(type, source);
	}
	const sources = [];
	for (const type of Array.from(sourcesMap.keys()).sort().reverse()) {
		const source = sourcesMap.get(type);
		sources.push({
			type,
			srcset: source?.srcset.join(', ')
		});
	}
	//Fallback if we don't have over src
	if (!src) {
		src = original.src;
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
	id = id.toString().length > 3 ? id.toString().slice(0, 3) : id;
	return `https://picsum.photos/id/${id}/400/600`;
}
