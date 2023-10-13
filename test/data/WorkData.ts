import type { Work } from '$lib/interfaces/Work';
import PictureData from '$test/data/PictureData';
import { UserBasicData, user_basic_data_raw } from './UserData';
import type { work_raw } from '$lib/server/repositories/work';
import { image_raw_data } from './PictureData';
import type { work_details_raw } from '$lib/server/repositories/work';
import { work_titels_data_raw } from './TitlesData';

const work_details_data_raw = {
	year: null,
	width: null,
	height: null,
	length: null
} satisfies work_details_raw;

export const work_data_raw = {
	id: BigInt(1),
	published_at: null,
	rating: 0,
	comments: 0,
	hosts: 0,
	price: 0,
	full: image_raw_data,
	preview: null,
	images: [],
	titles: work_titels_data_raw,
	owners: [{ user: user_basic_data_raw }],
	votes: [{ user: user_basic_data_raw }],
	tags: [],
	details: work_details_data_raw
} satisfies work_raw;

export const WorkData = {
	id: BigInt(1),
	published_at: new Date('2023-05-01T21:37:31.000Z'),
	rating: 0,
	comments: 0,
	hosts: 0,
	price: 0,
	titles: work_titels_data_raw,
	preview: PictureData,
	owners: [UserBasicData],
	year: null,
	width: null,
	height: null,
	length: null,
	tags: [],
	votes: [],
	full: null,
	images: []
} satisfies Work;
