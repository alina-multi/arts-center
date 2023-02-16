import {sveltekit} from '@sveltejs/kit/vite';
import type {UserConfig} from 'vite';
import * as path from "path";

const config: UserConfig = {
    plugins: [sveltekit()],
    server: {
        port: 3000,
        strictPort: false,
    },
    test: {
        include: ['src/**/*.{test,spec}.{js,ts}']
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './src/lib/components'),
            '$lib': path.resolve(__dirname, './src/lib'),
        },
    },
};

export default config;
