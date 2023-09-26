<script lang='ts'>
	import { localePath } from '$lib/translations';
	import * as devalue from 'devalue';
	import ImageWork from '$lib/components/atoms/ImageWork.svelte';
	import InfiniteScroll from '$lib/components/atoms/InfiniteScroll.svelte';
	import MetaGroups from '$lib/components/MetaGroups.svelte';
	import { t } from '$lib/translations';

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
		let url = localePath(`/api/user/${user.id}/${params.tag}/${page}`);
		const response = await fetch(url);
		const text = await response.text();
		const data = devalue.parse(text);
		newBatch = data.gallery;
		if (newBatch.length < 20) {
			hasMore = false;
		}
		loading = false;
	}
</script>
<MetaGroups title={$t('global.seo.title.user', user)} description={user?.bio} image={user?.photo} />

<ul class=' grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3'>
	{#each gallery as work}
		<li>
			<ImageWork {work} withDesription />
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