<script lang="ts">
	import type { PageData } from './$types';
	import HeaderLayout from '$lib/components/my/HeaderLayout.svelte';
	import { t } from '$lib/translations';
	import FilteredTable from '$lib/components/table/FilteredTable.svelte';
	import PictureCell from '$lib/components/table/PictureCell.svelte';
	import WorkStatusCell from '$lib/components/table/WorkStatusCell.svelte';
	import WorkControllsCell from '$lib/components/table/WorkControllsCell.svelte';

	export let data: PageData;

	const columns = [
		{
			title: 'id',
			field: 'id'
		},
		{
			title: $t('my.works_page.image'),
			component: PictureCell
		},
		{
			title: $t('my.works_page.titles'),
			field: 'titles',
			valueFn(row) {
				return row?.titles?.map((title) => `${title.language}: ${title.title}`).join('<br>');
			}
		},
		{
			title: $t('my.works_page.status'),
			component: WorkStatusCell
		},
		{
			title: '',
			component: WorkControllsCell
		}
	];
</script>

<HeaderLayout title={$t('my.my_works')}>
	<span slot="details"
		>{data.gallery.length}
		{data.gallery.length === 1 ? $t('my.work') : $t('my.works')}
	</span>
</HeaderLayout>
<FilteredTable {columns} data={data.gallery} />
