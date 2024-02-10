<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { MapPin } from '@steeze-ui/heroicons';
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
	<div class="inline-flex items-center">
		<Icon src={MapPin} theme="solid" class="  w-[16px] fill-green-900/80 dark:fill-green-700" />
		<span>{country}</span>
	</div>
{/if}
