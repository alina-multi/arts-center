import { sveltekit } from '@sveltejs/kit/vite';
import { defineConfig } from 'vitest/config';
import { loadEnv } from 'vite';
import { sentryVitePlugin } from '@sentry/vite-plugin';

export default defineConfig(({ mode }) => {
	const env = loadEnv(mode, process.cwd(), '');
	const useMockData = (env.USE_MOCK_DATA || process.env.USE_MOCK_DATA) === 'true';

	const sentryAuthToken = env.SENTRY_AUTH_TOKEN || process.env.SENTRY_AUTH_TOKEN;

	return {
		plugins: [
			sveltekit(),
			...(sentryAuthToken
				? [
						sentryVitePlugin({
							org: 'artsinua',
							project: 'frontend3',
							authToken: sentryAuthToken,
							sourcemaps: {
								assets: './build/**'
							}
						})
					]
				: [])
		],
		server: {
			port: 3000,
			strictPort: false,
			proxy: useMockData
				? undefined
				: {
						// Proxy API requests to Laravel backend
						'/api': {
							target: 'http://localhost:8000',
							changeOrigin: true,
							secure: false
						},
						// Proxy auth requests to Laravel backend
						'/auth': {
							target: 'http://localhost:8000',
							changeOrigin: true,
							secure: false
						}
					}
		},
		preview: {
			port: 3000,
			strictPort: false
		},
		test: {
			include: ['src/**/*.{test,spec}.{js,ts}']
		}
	};
});
