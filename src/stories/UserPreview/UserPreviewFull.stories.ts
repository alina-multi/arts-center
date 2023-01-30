import UserPreviewFull from '@/UserPreview/UserPreviewFull.svelte';
import type { Meta, StoryFn } from '@storybook/svelte';

export default {
	title: 'UserPreview/UserPreviewFull',
	component: UserPreviewFull,
	argTypes: {
		
	
	}
} satisfies Meta<UserPreviewFull>;

const Template: StoryFn<typeof UserPreviewFull> = (args) => ({
	Component: UserPreviewFull,
	props: args
});

// Todo: figure out why ts complains here
export const Full = Template.bind({});
Full.args = {
	id: 6455,
	users: [
		{
			id: 6455,
			subscribed: true,
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
			ratings: [
				{
					id: 21831,
					ratable_type: 'user',
					ratable_id: 6455,
					rating: 670,
					user_id: 6455,
					language: 'en'
				},
				{
					id: 21839,
					ratable_type: 'tag',
					ratable_id: 1,
					rating: 617,
					user_id: 6455,
					language: 'en'
				}
			]
		},
		{
			id: 6455,
			subscribed: false,
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
			ratings: [
				{
					id: 21831,
					ratable_type: 'user',
					ratable_id: 6455,
					rating: 670,
					user_id: 6455,
					language: 'en'
				},
				{
					id: 21839,
					ratable_type: 'tag',
					ratable_id: 1,
					rating: 617,
					user_id: 6455,
					language: 'en'
				}
			]
		},
		{
			id: 6455,
			subscribed: false,
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
			ratings: [
				{
					id: 21831,
					ratable_type: 'user',
					ratable_id: 6455,
					rating: 670,
					user_id: 6455,
					language: 'en'
				},
				{
					id: 21839,
					ratable_type: 'tag',
					ratable_id: 1,
					rating: 617,
					user_id: 6455,
					language: 'en'
				}
			]
		}
	],

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
