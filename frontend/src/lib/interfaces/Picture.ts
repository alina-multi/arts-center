export interface Picture {
	src: string;
	sources: {
		type: string;
		srcset: string;
	}[];
	original: {
		src: string;
		width: number;
		height: number;
	};
}
