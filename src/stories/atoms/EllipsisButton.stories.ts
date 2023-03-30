import EllipsisButton from '$lib/components/atoms/buttons/EllipsisButton.svelte';
import type { Meta, StoryFn } from '@storybook/svelte';

export default {
	title: 'Atoms/EllipsisButton',
	component: EllipsisButton,
	argTypes: {
		options: { control: 'array' }
	}
} satisfies Meta<EllipsisButton>;

const Template: StoryFn<typeof EllipsisButton> = (args) => ({
	Component: EllipsisButton,
	props: args
});

// Todo: figure out why ts complains here
export const EllipsisPopUp = Template.bind({});
EllipsisPopUp.args = {
	options: [
		{ label: 'Edit', value: 'edit', href: '/' },
		{ label: 'Delete', value: 'delete', href: '/' },
		{ label: 'View', value: 'view', href: '/' }
	]
};
