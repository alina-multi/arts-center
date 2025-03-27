<script lang="ts">
	import { getContext } from 'svelte';
	import { languageFind } from '$lib/translations';
	export let work;
	const locale = getContext('locale');
	const t = getContext('t');
	let description = languageFind(work.titles, $locale)?.description;
</script>

{#if description}
	<div class="max-md:px-4 space-y-3 block">
		<div class="font-bold">{$t('global.work_page.description')}</div>
		<p class="whitespace-pre-line">
			{description ?? ''}
		</p>
	</div>
{/if}
