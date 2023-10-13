import type { WorkPreview } from '$lib/interfaces/Work';
import { WorkTitleData } from './WorkTitleData';
import { user, UserData } from './UserData';
import type { work_raw } from '$lib/server/repositories/work';

export const work = {
	id: 1n,
	published_at: null,
	rating: 0,
	comments: 0,
	hosts: 0,
	price: 0,
	titles: [],
	owners: [{ user }],
	preview: null,
	status: 2
} satisfies work_raw;

export const WorkPreviewData = {
	id: 1n,
	published_at: null,
	rating: 0,
	status: 2,
	comments: 0,
	hosts: 0,
	price: null,
	titles: [{ ...WorkTitleData }, { ...WorkTitleData, language: 'EN', title: 'Title' }],
	owners: [UserData],
	preview: null
} as WorkPreview;
