import { worksPreviewMap } from './gallery';
import { expect, test } from 'vitest';
import {  WorkPreviewData } from '$test/data/WorkPreviewData';
import { work_data_raw } from '$test/data/WorkData';

const works = [{ ...work_data_raw }, { ...work_data_raw, id: 2n }];
const works_result = [{ ...WorkPreviewData }, { ...WorkPreviewData, id: 2n }];

test('worksPreviewMap', () => {
	const result = worksPreviewMap(works);
	expect(result).toStrictEqual(works_result);
});
      