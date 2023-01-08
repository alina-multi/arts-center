import "../src/lib/css/app.css"
import ThemeDecorator from "./ThemeDecorator.svelte";

export const parameters = {
  actions: {argTypesRegex: "^on[A-Z].*"},
  controls: {
    matchers: {
      color: /(background|color)$/i,
      date: /Date$/,
    },
  },
}

export const globalTypes = {
  theme: {
    name: 'Theme',
    description: 'Global theme for components',
    defaultValue: 'light',
    toolbar: {
      // Array of plain string values or MenuItem shape (see below)
      items: [
        { value: 'light', icon:'circlehollow', title: 'Light' },
        { value: 'dark', icon:'circle', title: 'Dark' },
      ],
      // Property that specifies if the name of the item will be displayed
      showName: true,
      // Change title based on selected value
      dynamicTitle: true,
    },
  },
};
export const decorators = [(_, context) => ({Component: ThemeDecorator, props: {context}})];