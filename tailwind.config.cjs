/** @type {import('tailwindcss').Config} */
module.exports = {
	darkMode: 'class',
	content: ['./public/**/*.html', './src/**/*.{html,js,svelte,ts}'],
	mode: 'jit',
	theme: {
		extend: {},
		fontFamily: {
			sans: ['Helvetica, sans-serif']
		}
	},
	plugins: [require('@tailwindcss/forms'), require('@tailwindcss/aspect-ratio')],
	safelist: [
		'bg-black',
		'bg-white',
		// Badge.svelte
		{
			pattern: /bg-(red|green|blue|orange|gray)-50/
		},
		{
			pattern: /text-(red|green|blue|orange|gray)-700/
		},
		{
			pattern: /ring-(red|green|blue|orange|gray)-600\/10/
		}
	]
};
