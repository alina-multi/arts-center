<script lang="ts">
	import type { PageData } from './';
	import FilteredTable from '$lib/components/table/FilteredTable.svelte';
	import { getContext } from 'svelte';
	import PostControllsCell from '$lib/components/table/PostControllsCell.svelte';
	import PublishedAtCell from '$lib/components/table/PublishedAtCell.svelte';

	const t = getContext('t');
	export let data: PageData;

	const columns = [
		{
			title: 'id',
			field: 'id'
		},
		{
			title: $t('my.post.title'),
			field: 'title'
		},
		{
			title: $t('my.post.published_at'),
			field: 'published_at',
			component: PublishedAtCell
		},
		{
			title: '',
			component: PostControllsCell
		}
	];
</script>

<FilteredTable {columns} data={data.posts} />
