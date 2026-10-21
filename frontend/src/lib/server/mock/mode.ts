import { env } from '$env/dynamic/private';

export function useMockData() {
	return env.USE_MOCK_DATA === 'true';
}
