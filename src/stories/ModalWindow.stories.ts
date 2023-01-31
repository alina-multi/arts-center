import ModalWindow from "@/ModalWindow.svelte";
import type {Meta, StoryFn} from '@storybook/svelte';

export default {
    title: "ModalWindow",
    component: ModalWindow,
    argTypes: {
        isOpened: {control: 'boolean'},
    }
} satisfies Meta<ModalWindow>

const Template: StoryFn<typeof ModalWindow> = (args) => ({
    Component: ModalWindow,
    props: args,
});

// Todo: figure out why ts complains here
export const Modal = Template.bind({});
Modal.args = {
open: true,
}


