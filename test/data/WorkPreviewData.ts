import type { WorkPreview } from '$lib/interfaces/Work';
import { UserBasicData } from './UserData';
import { work_titels_data_raw } from './TitlesData';

export const WorkPreviewData = {
	id: BigInt(1),
	published_at: null,
	rating: 0,
	status: undefined,
	comments: 0,
	hosts: 0,
	price: null,
	titles: work_titels_data_raw,
	owners: [UserBasicData],
	preview: null
} as WorkPreview;
