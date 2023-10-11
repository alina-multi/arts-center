import type { User } from './User';

export interface Comment {
	id: bigint;
	text: string | null;
	deleted_at: Date | null;
	created_at: Date | null ;
	updated_at: Date | null;
	rating: number;
	owner: User;
	answers?: Comment[];
}
