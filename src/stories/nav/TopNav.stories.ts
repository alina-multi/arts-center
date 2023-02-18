import TopNav from '$lib/components/nav/TopNav.svelte';
import type { Meta } from '@storybook/svelte';

export default {
	title: 'Nav/TopNav',
	component: TopNav,
	argTypes: {
		test: { control: 'text' }
	}
} satisfies Meta<TopNav>;

const Template = (args) => ({
	Component: TopNav,
	props: args
});

export const Primary = Template.bind({});
Primary.args = { test: 'test' };
