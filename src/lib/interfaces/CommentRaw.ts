import type { UserBasicRaw } from './UserRaw';

export interface CommentRaw {
	id: bigint;
	text: string;
	rating: number;
	deleted_at: Date | null;
	created_at: Date;
	updated_at: Date;
	comment_id: bigint | null;
	owner: UserBasicRaw;
}
