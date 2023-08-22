<script lang="ts">
	import type { User } from '$lib/interfaces/User';
	import Country from '$lib/components/user/UserCountry.svelte';
	import TotalRating from '$lib/components/user/TotalRating.svelte';
	import OnArtsSince from '$lib/components/atoms/OnArtsSince.svelte';

	export let user: User,
		full: boolean = false;
</script>

{#if full}
	<div class="flex flex-col sm:max-xl:flex-row sm:max-xl:gap-3 gap-1 xl:items-center">
		<div class="flex flex-wrap items-center gap-1 sm:max-xl:gap-3 xl:justify-center">
			<span>@{user?.username}</span>

			<Country {user} />
		</div>

		<OnArtsSince {user} />
	</div>
	<div class="hidden xl:block border-b h-1 dark:border-gray-700 w-full my-2" />
	<TotalRating {user} full forSubscribed/>
{:else}

	<TotalRating {user} forSubscribed/>
	<div class="flex flex-wrap text-sm text-zinc-500 gap-1 md:gap-2 items-center">
		<span>@{user?.username}</span>
		<Country {user} />
	</div>
{/if}
