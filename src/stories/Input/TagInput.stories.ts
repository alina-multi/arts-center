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
		placeholder: { control: 'text' },
	
	}
});

export const Tag = Template.bind({});
Tag.args = {
	label: 'Add tags',
	name: 'tags',
	value: '',
	placeholder: 'Enter some tags',
	tags: ['tag1', 'tag2'],
	error: false,
	// options: ['tag1', 'tag2', 'tag3', 'tag4', 'tag5', 'tag6', 'tag7', 'tag8', 'tag9', 'tag10'],
	options: function () {
		return new Promise((resolve) => {
			setTimeout(() => {
				resolve(['tag1', 'tag2', 'tag3', 'tag4', 'tag5', 'tag6', 'tag7', 'tag8', 'tag9', 'tag10']);
			}, 1000);
		});
	}

};
