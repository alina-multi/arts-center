import type { WorkPreview } from '$lib/interfaces/Work';
import { WorkTitleData } from './WorkTitleData';
import { user, UserData } from './UserData';

export const work = {
	id: 1n,
	published_at: null,
	rating: 0,
	comments: 0,
	hosts: 0,
	price: null,
	titles: [{ ...WorkTitleData }, { ...WorkTitleData, language: 'EN', title: 'Title' }],
	owners: [{ user }],
	preview: undefined,
	status: 2
};

export const WorkPreviewData = {
	id: 1n,
	published_at: null,
	rating: 0,
	comments: 0,
	hosts: 0,
	price: null,
	titles: [{ ...WorkTitleData }, { ...WorkTitleData, language: 'EN', title: 'Title' }],
	owners: [UserData],
	preview: null
} as WorkPreview;
