import type { Comment } from '$lib/interfaces/Comment';
import UserData from './UserData';
import type { comments } from '@prisma/client';

export default {
	id: 11n,
	commentable_type: 'comment',
	commentable_id: 11n,
	text: "At last the Mouse, sharply and very soon finished off the top of its mouth, and addressed her in an offended tone, and she very seldom followed it), and sometimes she scolded herself so severely as to the other, and making faces at him as he spoke, and then turned to the fifth bend, I think?' 'I.",
	body: '',
	comment_id: null,
	user_id: 12n,
	depth: 0,
	deleted_at: null,
	created_at: new Date('1975-08-19T23:15:30.000Z'),
	updated_at: new Date('1975-08-19T23:15:30.000Z'),
	rating: 1,
	owner: UserData
} as comments;

export const CommentData = {
	owner: UserData,
	id: 564n,
	text: "At last the Mouse, sharply and very soon finished off the top of its mouth, and addressed her in an offended tone, and she very seldom followed it), and sometimes she scolded herself so severely as to the other, and making faces at him as he spoke, and then turned to the fifth bend, I think?' 'I.",
	deleted_at: null,
	created_at: new Date('1975-08-19T23:15:30.000Z'),
	updated_at: new Date('1975-08-19T23:15:30.000Z'),
	rating: 1
} as Comment;
