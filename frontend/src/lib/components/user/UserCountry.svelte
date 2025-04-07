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
	<span>{country}</span>
{/if}
