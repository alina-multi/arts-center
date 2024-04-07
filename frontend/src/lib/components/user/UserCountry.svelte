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
	<div class="inline-flex items-center gap-1">
		<div class="rounded-full h-1 w-1 bg-zinc-900"></div>
		<span>{country}</span>
	</div>
{/if}
