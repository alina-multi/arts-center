import { worksPreviewMap } from './gallery';
import { expect, test } from 'vitest';
import { work, WorkPreviewData } from '$test/data/WorkPreviewData';

const works = [{ ...work }, { ...work, id: 2n }];
const works_result = [{ ...WorkPreviewData }, { ...WorkPreviewData, id: 2n }];

test('worksPreviewMap', () => {
	const result = worksPreviewMap(works);
	expect(result).toStrictEqual(works_result);
});
