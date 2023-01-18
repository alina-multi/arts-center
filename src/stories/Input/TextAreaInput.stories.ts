import TextAreaInput from '@/Input/TextAreaInput.svelte';
import type { Meta, StoryFn } from '@storybook/svelte';

export default {
	title: 'Input/TextAreaInput',
	component: TextAreaInput
} satisfies Meta<TextAreaInput>;

const Template: StoryFn<typeof TextAreaInput> = (args) => ({
	Component: TextAreaInput,
	props: args,
	argTypes: {
		label: { control: 'text' },
		description: { control: 'text' },
		name: { control: 'text' },
		placeholder: { control: 'text' },
		error: { control: 'text' },
		value: { control: 'text' }
	}
});

export const TextArea = Template.bind({});
TextArea.args = {
	label: 'Add your comment',
	description: '',
	name: 'comment',
	placeholder: 'Start typing here...',
	error: '',
	value: ''
};
