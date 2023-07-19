import { describe, expect, it } from 'vitest';
import { render } from '@testing-library/svelte';
import WorkPage from './WorkPage.svelte';
import type { Work } from '$lib/interfaces/Work';
import type { Comment } from '$lib/interfaces/Comment';
import WorkData from '$test/data/WorkData';
interface WorkPageProps {
	work: Work;
	comments: Comment[];
}
describe('Work page', () => {
	it('Work page renders with valid data', () => {
		const { getByText } = render(WorkPage, {
			work: WorkData,
			comments: [],
			currentUser: null
		} as WorkPageProps);

		expect(() => getByText('Тестовий заголовок')).not.toThrow();
	});
});
