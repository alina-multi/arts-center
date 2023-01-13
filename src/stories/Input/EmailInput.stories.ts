import EmailInput from "@/Input/EmailInput.svelte";
import type { Meta, StoryFn } from '@storybook/svelte';

export default {
    title: "Input/EmailInput",
    component: EmailInput,
    argTypes: {
        type: { control: 'text' },
        placeholder: { control: 'text' },
        inputType: { control: 'radio', options: ['primary', 'error'] },
        spanLabel: { control: 'text' },
    }
} satisfies Meta<EmailInput>

const Template:StoryFn<typeof EmailInput> = (args) => ({
    Component: EmailInput,
    props: args,
});

export const Email = Template.bind({});
Email.args = { 
    type: "email",
    label: "Email",
    placeholder: "you@example.com",
    inputType: "primary",
    spanLabel: "We'll only use this for spam",
}


