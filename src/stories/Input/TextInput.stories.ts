import TextInput from '@/Input/TextInput.svelte';
import type { Meta, StoryFn } from '@storybook/svelte';

export default {
	title: 'Input/TextInput',
	component: TextInput,
	argTypes: {
		label: { control: 'text' },
		description: { control: 'text' },
		name: { control: 'text' },
		placeholder: { control: 'text' },
		error: { control: 'text' },
		value: { control: 'text' }
	}
} satisfies Meta<TextInput>;

const Template: StoryFn<typeof TextInput> = (args) => ({
	Component: TextInput,
	props: args
});

export const Text = Template.bind({});
Text.args = {
	label: 'Name',
	description: '',
	name: 'firstName',
	placeholder: 'First Name',
	error: '',
	value: ''
};
