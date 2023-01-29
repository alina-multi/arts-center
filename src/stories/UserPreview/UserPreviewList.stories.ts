import UserPreviewList from '@/UserPreview/UserPreviewList.svelte';
import type { Meta, StoryFn } from '@storybook/svelte';

export default {
	title: 'UserPreview/UserPreviewList',
	component: UserPreviewList,
	argTypes: {
    options: { control: 'array' },
    filters: { control: 'array' },
		
	}
} satisfies Meta<UserPreviewList>;

const Template: StoryFn<typeof UserPreviewList> = (args) => ({
	Component: UserPreviewList,
	props: args
});

export const List = Template.bind({});
List.args = {
	options: [
 { name: 'Most Popular', value: '1', href: '#', current: true },
  { name: 'Best Rating', value: '2', href: '#', current: false },
  { name: 'Newest', value: '7',  href: '#', current: false },
	],
	
	filters: [
  {
    id: 'category',
    name: 'Category',
    options: [
      { value: 'new-arrivals', label: 'All New Arrivals', checked: false },
      { value: 'tees', label: 'Tees', checked: false },
      { value: 'objects', label: 'Objects', checked: false },
    ],
  },
  {
    id: 'color',
    name: 'Color',
    options: [
      { value: 'white', label: 'White', checked: false },
      { value: 'beige', label: 'Beige', checked: false },
      { value: 'blue', label: 'Blue', checked: false },
    ],
  },
  {
    id: 'sizes',
    name: 'Sizes',
    options: [
      { value: 's', label: 'S', checked: false },
      { value: 'm', label: 'M', checked: false },
      { value: 'l', label: 'L', checked: false },
    ],
  },
]

};
