import type { Work } from '$lib/interfaces/Work';
import PictureData from '$test/data/PictureData';
import { work_titels_data_raw } from './WorkPreviewData';


export const WorkData = {
	id: BigInt(1),
	published_at: new Date('2023-05-01T21:37:31.000Z'),
	rating: 0,
	comments: 0,
	hosts: 0,
	price: 0,
	titles: work_titels_data_raw ,
	preview: PictureData,
	owners: [],
	year:  null,
	width: null,
	height: null,
	length: null,
	tags: [],
	votes: [],
	full:  null,
	images: [],

} satisfies Work;