/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
	darkMode: 'class',
	content: ['./public/**/*.html', './src/**/*.{html,js,svelte,ts}'],
	mode: 'jit',
	theme: {
		extend: {
			keyframes: {
				animatedgradient: {
					'0%': { backgroundPosition: '0% 50%' },
					'50%': { backgroundPosition: '100% 50%' },
					'100%': { backgroundPosition: '0% 50%' }
				}
			},
			backgroundSize: {
				'300%': '300%'
			},
			animation: {
				gradient: 'animatedgradient 6s ease infinite alternate'
			}
		},

		screens: {
			xs: '500px',
			...defaultTheme.screens
		}
	},
	plugins: [require('@tailwindcss/forms'), require('@tailwindcss/aspect-ratio'), 	require('tailwind-scrollbar-hide')],

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
