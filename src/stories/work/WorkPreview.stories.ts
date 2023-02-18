import WorkPreview from '@/WorkPreview/WorkPreview.svelte';
import type { Meta, StoryFn } from '@storybook/svelte';

export default {
	title: 'WorkPreview/WorkPreview',
	component: WorkPreview,
	argTypes: {
		subscribed: { control: 'boolean' }
	}
} satisfies Meta<WorkPreview>;

const Template: StoryFn<typeof WorkPreview> = (args) => ({
	Component: WorkPreview,
	props: args
});

// Todo: figure out why ts complains here
export const Preview = Template.bind({});
Preview.args = {
	works: [
        {
		id: 4155,
        author: 'Gabriolis LoremIpsum Vasilis',
        userPhoto: 'https://api.lorem.space/image/face?w=280&h=280',
		subscribed: true,
		image_id: 15899,
		rating: 22345,
		comments: 6,
		price: 0,
		title: 'My grandfather, Vitaly Gorolyu',
		image: {
			url: 'https://api.lorem.space/image/movie?w=1440&h=1080',
			srcset: ''
		}
	},
    {
		id: 4525,
        author: 'Lorem Ipsum',
        userPhoto: 'https://api.lorem.space/image/fashion?w=280&h=280',
		subscribed: false,
		image_id: 15689,
		rating: 25,
		comments: 0,
		price: 234,
		title: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
		image: {
			url: 'https://api.lorem.space/image/fashion?w=1440&h=1080',
			srcset: ''
		}
	},
    {
		id: 415525,
        author: 'John Doe LoremIpsum LoremIpsum',
        userPhoto: 'https://api.lorem.space/image/book?w=280&h=280',
		subscribed: true,
		image_id: 156899,
		rating: 0,
		comments: 6456,
		price: 330000,
		title: "Скалы Ponta de São Lourenço",
		image: {
			url: 'https://api.lorem.space/image/book?w=1440&h=1080',
			srcset: ''
		}
	},
    {
		id: 415445,
        author: 'Gabriolis ',
        userPhoto: 'https://api.lorem.space/image/movie?w=280&h=280',
		subscribed: false,
		image_id: 15899,
		rating: 22345,
		comments: 6,
		price: 0,
		title: 'My grandfather, Vitaly Gorolyu',
		image: {
			url: 'https://api.lorem.space/image/movie?w=1440&h=1080',
			srcset: ''
		}
	},
],

};
