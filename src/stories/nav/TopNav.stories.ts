import TopNav from "$lib/components/nav/TopNav.svelte";
import type { Meta, StoryObj, StoryFn } from '@storybook/svelte';

export default {
    title: "Nav/TopNav",
    component: TopNav,
} satisfies Meta<TopNav>

const Template:StoryFn<typeof TopNav> = (args) => ({
    Component: TopNav,
    props: args,
});

export const Primary = Template.bind({});
Primary.args = { };
