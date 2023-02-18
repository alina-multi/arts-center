import RatingPreview from '@/Rating/RatingPreview.svelte';
import type { Meta, StoryFn } from '@storybook/svelte';

export default {
	title: 'Rating/RatingPreview',
	component: RatingPreview,
	argTypes: {}
} satisfies Meta<RatingPreview>;

const Template: StoryFn<typeof RatingPreview> = (args) => ({
	Component: RatingPreview,
	props: args
});

// Todo: figure out why ts complains here
export const Primary = Template.bind({});
Primary.args = {
	rating: 45678,
	comments: 456
};
