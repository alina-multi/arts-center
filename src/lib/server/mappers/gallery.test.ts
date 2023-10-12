import { worksPreviewMap } from './gallery';
import { expect, test } from 'vitest';
import { work_data_raw, WorkPreviewData } from '$test/data/WorkPreviewData';

const works = [{ ...work_data_raw }, { ...work_data_raw, id: 2n }];
const works_result = [{ ...WorkPreviewData }, { ...WorkPreviewData, id: 2n }];

test('worksPreviewMap', () => {
	const result = worksPreviewMap(works);
	expect(result).toStrictEqual(works_result);
});
