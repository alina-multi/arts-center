export interface ImageRaw {
	id: bigint;
	folder: ImageFolder;
	variants: VariantsRaw[] | [];
}

export interface VariantsRaw {
	id: bigint;
	extension: string;
	width: number;
	height: number;
	size: number;
	original: boolean;
}

export type ImageFolder = 'preview' | 'works' | 'photos' | 'grids';
