import { defineConfig } from 'vitest/config';
import { svelte } from '@sveltejs/vite-plugin-svelte';
import * as path from 'path';

export default defineConfig({
	plugins: [svelte({ hot: false })],
	resolve: {
		alias: {
			$lib: path.resolve(__dirname, './src/lib'),
			// We need this for tests/mocks
			$app: path.resolve(__dirname, './test/app'),
			$test: path.resolve(__dirname, './test'),
			$env:  path.resolve(__dirname, './test/env'),
		}
	},
	test: {
		globals: true,
		environment: 'jsdom',
		setupFiles: ['./vitest.setup.ts']
	}
});
