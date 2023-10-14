import type { UserBasicRaw } from './UserRaw';

export interface CommentRaw {
	id: bigint;
	text: string | null;
	rating: number;
	deleted_at: Date | null;
	created_at: Date | null;
	updated_at: Date | null;
	comment_id: bigint | null;
	owner: UserBasicRaw;
}
