export interface Tag {
	id: bigint;
	count: number | null;
	titles: TagTitle[];
}

export interface TagTitle {
	title: string;
	language: string;
}
