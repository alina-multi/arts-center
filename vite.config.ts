import { sveltekit } from '@sveltejs/kit/vite';
import { defineConfig } from 'vitest/config';
import {sentryVitePlugin} from '@sentry/vite-plugin';
import path from 'path';

export default defineConfig({
	plugins: [
		sveltekit(),
		sentryVitePlugin({
			org: 'artsinua',
			project: 'frontend3',
			authToken: '812e77e7c836423d8240ff1bf9608911959ae4161b1d410e8ee6fbdfaa322e3a',
			sourcemaps: {
				// Specify the directory containing build artifacts
				assets: './build/**',
			},
		}),
	],
	server: {
		port: 3000,
		strictPort: false
	},
	preview: {
		port: 3000,
		strictPort: false
	},
	test: {
		include: ['src/**/*.{test,spec}.{js,ts}']
	},
	// This is already added by sveltekit, but phpstorm doesn't know that
	resolve: {
		alias: {
			$lib: path.resolve(__dirname, './src/lib')
		}
	}
});
