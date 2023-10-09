import { beforeAll, describe, expect, it } from 'vitest';
import { render, screen } from '@testing-library/svelte';
import WorkPage from './WorkPage.svelte';
import type { Work } from '$lib/interfaces/Work';
import type { Comment } from '$lib/interfaces/Comment';
import WorkData from '$test/data/WorkData';
import { loadTranslations } from '$lib/translations';
import { user } from '$lib/stores/auth';
import { UserData } from '$test/data/UserData';
interface WorkPageProps {
	work: Work;
	comments: Comment[];
}
beforeAll(async () => {
	await loadTranslations('uk', '/uk/work/39');
});
describe('Work page', async () => {
	it('Not owning the work', async () => {
		render(WorkPage, {
			work: WorkData,
			comments: []
		} as WorkPageProps);
		const heading = screen.getByText('Тестовий заголовок');
		expect(heading).toBeInTheDocument();
		const editButton = screen.queryByTestId('edit-work-button');
		expect(editButton).not.toBeInTheDocument();
	});
	it('My work', async () => {
		await user.set(UserData);
		render(WorkPage, {
			work: WorkData,
			comments: []
		} as WorkPageProps);
		screen.getByTestId('edit-work-button');
	});
});
