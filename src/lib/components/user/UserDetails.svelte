<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Star, MapPin } from '@steeze-ui/heroicons';
	import type { User } from '$lib/interfaces/User';

	export let user: User;
	if (user?.country?.length === 2) {
		const regionNames = new Intl.DisplayNames(['en'], { type: 'region' });
		const country = regionNames.of(user.country);
	}
</script>

<div
	class="flex  flex-wrap text-xs md:text-sm  text-gray-500/90 dark:text-gray-300 gap-1 md:gap-2  items-center "
>
	{#if user?.rating}
		<div class="flex items-center  ">
			<Icon src={Star} theme="solid" class=" h-[17px] w-[17px] fill-amber-600 " />
			<span> {user?.rating}</span>
		</div>
	{/if}

	<span>@{user?.username}</span>

	{#if country}
		<div class="inline-flex  items-center">
			<Icon
				src={MapPin}
				theme="solid"
				class=" h-[17px] w-[17px] fill-green-900/80 dark:stroke-gray-300"
			/>
			<span>{country}</span>
		</div>
	{/if}
</div>
