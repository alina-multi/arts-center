import type { UserBasic } from './User';

export interface Comment {
	id: bigint;
	text: string;
	deleted_at: Date | null;
	created_at: Date;
	updated_at: Date;
	rating: number;
	owner: UserBasic;
	answers?: Comment[];
}
