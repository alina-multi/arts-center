import WorkItem from "@/WorkPreview/WorkItem.svelte";
import type {Meta, StoryFn} from '@storybook/svelte';

export default {
    title: "WorkPreview/WorkItem",
    component: WorkItem,
    argTypes: {
       
       
    }
} satisfies Meta<WorkItem>

const Template: StoryFn<typeof WorkItem> = (args) => ({
    Component: WorkItem,
    props: args,
});

// Todo: figure out why ts complains here
export const Primary = Template.bind({});
Primary.args = {    
    title: "Work Item Title",
    subscribed: true,
}