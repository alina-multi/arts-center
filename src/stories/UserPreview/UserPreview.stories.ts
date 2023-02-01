import UserPreview from '@/UserPreview/UserPreview.svelte';
import type { Meta, StoryFn } from '@storybook/svelte';

export default {
	title: 'UserPreview/UserPreview',
	component: UserPreview,
	argTypes: {}
} satisfies Meta<UserPreview>;

const Template: StoryFn<typeof UserPreview> = (args) => ({
	Component: UserPreview,
	props: args
});

// Todo: figure out why ts complains here
export const UserSimple = Template.bind({});
UserSimple.args = {
	id: 6455,
	name: 'Атаманський  Святослав',
	username: 'Gabriolis',
	created_at: '2012-07-12T00:00:00.000000Z',
	country: null,
	totalRating: 612342,
	photo: {
		url: 'https://api.lorem.space/image/face?w=280&h=280',
		srcset:
			'https://i.arts.center/photos/atamanskii-svyatoslav-4502-w300.webp 300w, https://i.arts.center/photos/atamanskii-svyatoslav-4502-w300.jpeg 300w'
	},
	lastWorks: [
		{
			id: 415525,
			image_id: 156890,
			title: 'My grandfather, Vitaly Gorolyu',
			image: {
				url: 'https://api.lorem.space/image/fashion?w=1440&h=1080',
				srcset: ''
			}
		},
		{
			id: 415526,
			image_id: 156891,
			title: 'My grandfather, Vitaly Gorolyu',
			image: {
				url: 'https://api.lorem.space/image/book?w=1440&h=1080',
				srcset: ''
			}
		},
		{
			id: 415527,
			image_id: 156899,
			title: 'My grandfather, Vitaly Gorolyu',
			image: {
				url: 'https://api.lorem.space/image/movie?w=1440&h=1080',
				srcset: ''
			}
		}
	],

	tags: [
		{ rating: 617, name: 'Painting', url: '/', id: 1 },
		{ rating: 150, name: 'Blala', url: '/', id: 2 },
		{ rating: 3000, name: 'Lorem', url: '/', id: 3 },
		{ rating: 150, name: 'Blala', url: '/', id: 4 },
        { rating: 150, name: 'Blala', url: '/', id: 5 },
	]


};
