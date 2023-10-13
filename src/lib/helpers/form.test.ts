import { expect, test } from 'vitest';
import { formToObject } from '$lib/helpers/form';

test('formDotToObject', () => {
	const form = new FormData();
	form.set('test.array.0', '0');
	form.set('test.array.1', '1');
	form.set('test.array.2', '2');
	form.set('test.objects.0.field1', 'hello');
	form.set('test.objects.0.field2', 'world');
	form.set('test.objects.1.field3', 'hey');
	form.set('test.arr2d.0.0', '0.0');
	form.set('test.arr2d.0.1', '0.1');
	form.set('test.arr2d.1.0', '1.0');
	form.set('test.arr2d.1.1', '1.1');
	expect(formToObject(form)).toStrictEqual({
		test: {
			array: ['0', '1', '2'],
			objects: [
				{
					field1: 'hello',
					field2: 'world'
				},
				{
					field3: 'hey'
				}
			],
			arr2d: [
				['0.0', '0.1'],
				['1.0', '1.1']
			]
		}
	});
});
