import type { Comment } from '$lib/interfaces/Comment';
import { user_basic_data_raw, UserBasicData } from './UserData';
import type { CommentRaw } from '$lib/interfaces/raw/CommentRaw';

export const comment_raw_data = {
	id: 11n,
	text: "At last the Mouse, sharply and very soon finished off the top of its mouth, and addressed her in an offended tone, and she very seldom followed it), and sometimes she scolded herself so severely as to the other, and making faces at him as he spoke, and then turned to the fifth bend, I think?' 'I.",
	comment_id: null,
	deleted_at: null,
	created_at: new Date('1975-08-19T23:15:30.000Z'),
	updated_at: new Date('1975-08-19T23:15:30.000Z'),
	rating: 1,
	owner: user_basic_data_raw
} satisfies CommentRaw;

export const CommentData = {
	id: 11n,
	text: "At last the Mouse, sharply and very soon finished off the top of its mouth, and addressed her in an offended tone, and she very seldom followed it), and sometimes she scolded herself so severely as to the other, and making faces at him as he spoke, and then turned to the fifth bend, I think?' 'I.",
	deleted_at: null,
	created_at: new Date('1975-08-19T23:15:30.000Z'),
	updated_at: new Date('1975-08-19T23:15:30.000Z'),
	rating: 1,
	owner: UserBasicData
} satisfies Comment;
