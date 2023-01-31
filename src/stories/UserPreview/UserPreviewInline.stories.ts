import UserPreviewInline from "@/UserPreview/UserPreviewInline.svelte";
import type {Meta, StoryFn} from '@storybook/svelte';

export default {
    title: "UserPreview/UserPreviewInline",
    component: UserPreviewInline,
    argTypes: {
        name: {control: "text"},
       
    }
} satisfies Meta<UserPreviewInline>

const Template: StoryFn<typeof UserPreviewInline> = (args) => ({
    Component: UserPreviewInline,
    props: args,
});

// Todo: figure out why ts complains here
export const Inline = Template.bind({});
Inline.args = {
    name: "Атаманський Святослав",
    src: "https://i.arts.center/photos/atamanskii-svyatoslav-4502-w300.jpeg",
    srcset:"https://i.arts.center/photos/atamanskii-svyatoslav-4502-w300.webp 300w, https://i.arts.center/photos/atamanskii-svyatoslav-4502-w300.jpeg 300w",
  

}
