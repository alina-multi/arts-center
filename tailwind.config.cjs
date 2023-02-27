/** @type {import('tailwindcss').Config} */
module.exports = {
	darkMode: 'class',
	content: [
		'./public/**/*.html',
		'./src/**/*.{html,js,svelte,ts}',
		'./node_modules/flowbite-svelte/**/*.{html,js,svelte,ts}'
	],
	mode: 'jit',
	theme: {
		extend: {},
		fontFamily: {
			sans: [
				'Helvetica, sans-serif',
			 
			],
		  },
	},
	plugins: [
		require('@tailwindcss/forms'),
		require('@tailwindcss/aspect-ratio'),
		require('flowbite/plugin')
	],
	safelist: ['bg-black', 'bg-white']
};
