<script lang="ts">
	import type { PageData } from './$types';
	import Gallery from '$lib/components/work/Gallery.svelte';
	import MetaGroups from '$lib/components/MetaGroups.svelte';
	import {t} from '$lib/translations'
	export let data: PageData;
</script>

<MetaGroups title={$t('global.seo.title.gallery', data.params)}/>

<Gallery {...data} />
