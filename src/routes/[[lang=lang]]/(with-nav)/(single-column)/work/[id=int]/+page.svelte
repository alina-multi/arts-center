<script lang="ts">
	import type { PageData } from './$types';
	import WorkPage from '$lib/components/work/WorkPage.svelte';
	import { languageFind } from '$lib/translations';
	import MetaGroups from '$lib/components/MetaGroups.svelte';
	import {t} from '$lib/translations'

	export let data: PageData;

	let work = data.work;
	let title = languageFind(work.titles)?.title;
	let description = languageFind(work.titles)?.description
	let author = work.owners.map((owner) => owner.name).join(', ');
	let image = work?.full?.original?.src;
	
</script>

<MetaGroups title={$t('global.seo.title.work', {name: author, title})} {description} {author} {image} />

<WorkPage {...data} />
