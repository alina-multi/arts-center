import RatingPreviewVote from '@/Rating/RatingPreviewVote.svelte';
import type { Meta, StoryFn } from '@storybook/svelte';

export default {
	title: 'Rating/RatingPreviewVote',
	component: RatingPreviewVote,
	argTypes: {
		allowDownVote: { control: 'boolean' },
		showVotedPreview: { control: 'boolean' },
		typeOfVote: { control: 'boolean' },
		rating: { control: 'text' },

	}
} satisfies Meta<RatingPreviewVote>;

const Template: StoryFn<typeof RatingPreviewVote> = (args) => ({
	Component: RatingPreviewVote,
	props: args
});

// Todo: figure out why ts complains here
export const VoteButtons = Template.bind({});
VoteButtons.args = {
	allowDownVote: true,
	showVotedPreview: false,
	rating: 34567,
	typeOfVote: null,

	usersList: [
		{
			avatar: 'https://api.lorem.space/image/face?w=280&h=280',
			userPage: '/',
			name: 'user1',
			userId: 1,
		},
		{
			avatar: 'https://api.lorem.space/image/movie?w=280&h=280',
			userPage: '/',
			name: 'user1',
			userId: 1,
		},
		{
			avatar: 'https://api.lorem.space/image/fashion?w=280&h=280',
			userPage: '/',
			name: 'user1',
			userId: 1,
		}
	]
};