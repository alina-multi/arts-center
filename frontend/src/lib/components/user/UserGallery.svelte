<script lang="ts">
	import { localePath } from '$lib/translations';
	import { parse } from 'devalue';
	import ImageWork from '$lib/components/atoms/ImageWork.svelte';
	import InfiniteScroll from '$lib/components/atoms/InfiniteScroll.svelte';
	import MetaGroups from '$lib/components/MetaGroups.svelte';
	import { getContext } from 'svelte';
	import WorkModal from '$lib/components/work/WorkModal.svelte';

	const t = getContext('t');
	const locale = getContext('locale');

	export let gallery;
	export let params;
	export let user;

	let newBatch = [];
	let page = 1;
	let loading = false;
	let hasMore = gallery.length >= 20;

	$: gallery = [...gallery, ...newBatch];

	async function fetchData() {
		loading = true;
		let url = localePath($locale, `/api/user/${user.id}/${params.tag}/${page}`);
		const response = await fetch(url);
		const text = await response.text();
		const data = parse(text);
		newBatch = data.gallery;
		if (newBatch.length < 20) {
			hasMore = false;
		}
		loading = false;
	}
</script>

<MetaGroups title={$t('global.seo.title.user', user)} description={user?.bio} image={user?.photo} />

<ul class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
	{#each gallery as work, index (work.id)}
		<li>
			<ImageWork {work} withDesription loading={index > 9 ? 'lazy' : 'eager'} />
		</li>
	{/each}
	<InfiniteScroll
		{hasMore}
		{loading}
		on:loadMore={() => {
			page++;
			fetchData();
		}}
	/>
</ul>

<WorkModal {gallery} />
