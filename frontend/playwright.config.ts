import type { PlaywrightTestConfig } from '@playwright/test';

const config: PlaywrightTestConfig = {
	// webServer: {
	// 	command: 'yarn run build && yarn run preview',
	// 	port: 4173
	// },
	testDir: 'test'
};

export default config;
