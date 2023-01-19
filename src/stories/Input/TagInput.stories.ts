import TagInput from '@/Input/TagInput.svelte';
import type { Meta, StoryFn } from '@storybook/svelte';

export default {
	title: 'Input/TagInput',
	component: TagInput
} satisfies Meta<TagInput>;

const Template: StoryFn<typeof TagInput> = (args) => ({
	Component: TagInput,
	props: args,
	argTypes: {
		tags: { control: 'object' },
		label: { control: 'text' },
		name: { control: 'text' },
		errorDescription: { control: 'text' },
		placeholder: { control: 'text' }
	}
});

export const Tag = Template.bind({});
Tag.args = {
	label: 'Add tags',
	name: 'tags',
	placeholder: 'Enter some tags',
	tags: ['tag1', 'tag2'],
	errorDescription: 'Tag should be more than 3 characters'
};
