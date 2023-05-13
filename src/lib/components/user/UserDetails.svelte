<script lang="ts">
	import type { User } from '$lib/interfaces/User';
	import Country from '$lib/components/user/UserCountry.svelte';
	import TotalRating from '$lib/components/user/TotalRating.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { CalendarDays } from '@steeze-ui/heroicons';

	export let user: User, full: boolean;
</script>

{#if full}
	<div class="flex flex-col sm:max-xl:flex-row sm:max-xl:gap-3 gap-1 xl:items-center">
		<div class="flex flex-wrap items-center gap-1 sm:max-xl:gap-3 xl:justify-center">
			<span>@{user?.username}</span>

			<Country {user} />
		</div>

		<div class="flex gap-1 items-center">
			<Icon src={CalendarDays} class=" w-[17px]  " />
			<span>on arts since: </span>
			<span> {new Date(user.created_at).getFullYear()}</span>
		</div>
	</div>
	<div class="hidden xl:block border-b h-1 dark:border-gray-700 w-full my-2" />
	<TotalRating {user} full />
{:else}
	<div
		class="flex flex-wrap text-xs md:text-sm text-gray-500 dark:text-gray-300 gap-1 md:gap-2 items-center"
	>
		<TotalRating {user} />
		<span>@{user?.username}</span>
		<Country {user} />
	</div>
{/if}
