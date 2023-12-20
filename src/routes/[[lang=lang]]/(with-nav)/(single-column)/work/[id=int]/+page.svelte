<script lang="ts">
	import type { PageData } from './$types';
	import WorkPage from '$lib/components/work/WorkPage.svelte';
	import { languageFind } from '$lib/translations';
	import MetaGroups from '$lib/components/MetaGroups.svelte';
	import { getContext } from 'svelte';

	const t = getContext('t');
	const locale = getContext('locale');

	export let data: PageData;

	let work = data.work;
	let title = languageFind(work.titles, $locale)?.title;
	let description = languageFind(work.titles, $locale)?.description;
	let author = work.owners.map((owner) => owner.name).join(', ');
	let image = work?.full?.original?.src;
</script>

<MetaGroups
	title={$t('global.seo.title.work', { name: author, title })}
	{description}
	{author}
	{image}
/>

<WorkPage {...data} />
