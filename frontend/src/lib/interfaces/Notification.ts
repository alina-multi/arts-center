import type { Comment } from '$lib/interfaces/Comment';
import type { Work, WorkTitle } from '$lib/interfaces/Work';
import type { User } from '$lib/interfaces/User';

type BaseNotification = {
	id: string;
};

export const NotificationTypes = new Map([
	[1, 'SiteNews'],
	[20, 'FeaturedPosts'],
	[40, 'MyContentComment'],
	[41, 'MyContentVote'],
	[42, 'MyDirectMessage'],
	[60, 'SubscriptionPost'],
	[61, 'SubscriptionWork']
]);

export const NotificationChannels = new Map([
	[1, 'Mail'],
	[2, 'Web']
]);

export type NewWorkCommentNotification = BaseNotification & {
	type: 'App\\Notifications\\NewWorkComment';
	text: string;
	name: string;
	username: string;
	work_id: bigint;
	work_titles: WorkTitle[];
	comment_id: bigint;
};

export type NewReplyNotification = NewWorkCommentNotification & {
	original_text: string;
};

export type NewWorkVoteNotification = BaseNotification & {
	type: 'App\\Notifications\\NewWorkVote';
	votable: Work | Comment;
	user: User;
};

export type DonationReceived = BaseNotification & {
	total: string;
	message: string;
};

export type NewFollower = BaseNotification & {
	type: 'App\\Notifications\\NewFollower';
	name: string;
	username: string;
};

export type Notification =
	| NewWorkCommentNotification
	| NewWorkVoteNotification
	| NewReplyNotification
	| DonationReceived
	| NewFollower;
