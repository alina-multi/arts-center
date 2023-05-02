<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { MapPin } from '@steeze-ui/heroicons';
	export let user;
	let country;
	if (user?.country?.length === 2) {
		const regionNames = new Intl.DisplayNames(['en'], { type: 'region' });
		country = regionNames.of(user.country);
	}
</script>

{#if country}
	<div class="inline-flex  items-center">
		<Icon src={MapPin} theme="solid" class="  w-[16px] fill-green-900/80 dark:fill-green-700" />
		<span>{country}</span>
	</div>
{/if}
