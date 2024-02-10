import PasswordInput from '@/Input/PasswordInput.svelte';
import type { Meta, StoryFn } from '@storybook/svelte';

export default {
	title: 'Input/PasswordInput',
	component: PasswordInput,
	argTypes: {
		label: { control: 'text' },
		description: { control: 'text' },
		placeholder: { control: 'text' },
		value: { control: 'text' },
		error: { control: 'text' }
	}
} satisfies Meta<PasswordInput>;

const Template: StoryFn<typeof PasswordInput> = (args) => ({
	Component: PasswordInput,
	props: args
});

// Todo: figure out why ts complains here
export const Password = Template.bind({});
Password.args = {
	label: 'Password',
	name: 'password',
	description: 'Description',
	placeholder: 'Password',
	value: '',
	error: ''
};
