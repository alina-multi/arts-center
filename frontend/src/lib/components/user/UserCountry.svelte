<script lang="ts">
	import { getContext } from 'svelte';

	const locale = getContext('locale');
	export let user;

	let country = null;
	if (user?.country) {
		const regionNames = new Intl.DisplayNames([$locale], { type: 'region' });
		country = regionNames.of(user.country);
	}
</script>

{#if country}
	<div class="inline-flex items-center gap-1.5">
		<div class="rounded-full h-0.5 w-0.5 bg-zinc-400 dark:bg-zinc-300"></div>
		<span>{country}</span>
	</div>
{/if}
