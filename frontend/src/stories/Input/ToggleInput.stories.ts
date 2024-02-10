import ToggleInput from '@/Input/ToggleInput.svelte';
import type { Meta, StoryFn } from '@storybook/svelte';

export default {
	title: 'Input/ToggleInput',
	component: ToggleInput,
	argTypes: {
		enabled: { control: 'boolean' }
	}
} satisfies Meta<ToggleInput>;

const Template: StoryFn<typeof ToggleInput> = (args) => ({
	Component: ToggleInput,
	props: args,
	argTypes: {}
});

export const Toggle = Template.bind({});
Toggle.args = { enabled: true };
