export interface TagRaw {
	tag: {
		id: bigint;
		titles: TagTitleRaw[];
	};
}
export interface TagTitleRaw {
	title: string;
	language: string;
}
