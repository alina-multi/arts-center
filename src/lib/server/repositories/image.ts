export const imageSelect = {
	select: {
		id: true,
		folder: true,
		variants: {
			select: {
				id: true,
				extension: true,
				width: true,
				height: true,
				size: true,
				original: true
			}
		}
	}
};

export interface image_raw {
	id: bigint,
		folder: string,
		variants: variants[]}

export interface variants {
	id: bigint,
	extension: string,
	width: number,
	height: number,
	size: number,
	original: boolean
}


