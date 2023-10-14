export interface ImageRaw {
	id: bigint;
	folder: ImageFolder;
	variants: VariansRaw[] | [];
}

export interface VariansRaw {
	id: bigint;
	extension: string;
	width: number;
	height: number;
	size: number;
	original: boolean;
}

export type ImageFolder = 'preview' | 'works' | 'photos' | 'grids';
