import EmailInput from "@/Input/EmailInput.svelte";
import type {Meta, StoryFn} from '@storybook/svelte';

export default {
    title: "Input/EmailInput",
    component: EmailInput,
    argTypes: {
        label: {control: "text"},
        description: {control: "text"},
        placeholder: {control: 'text'},
        value: {control: "text"},
        error: {control: "text"},
    }
} satisfies Meta<EmailInput>

const Template: StoryFn<typeof EmailInput> = (args) => ({
    Component: EmailInput,
    props: args,
});

// Todo: figure out why ts complains here
export const Primary = Template.bind({});
Primary.args = {
    label: "Email",
    name: 'email',
    description: "",
    placeholder: "test@email.com",
    value: "",
    error: "",
}


