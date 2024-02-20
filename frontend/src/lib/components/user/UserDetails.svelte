<script lang="ts">
	import type { User } from '$lib/interfaces/User';
	import Country from '$lib/components/user/UserCountry.svelte';
	import TotalRating from '$lib/components/user/TotalRating.svelte';

	export let user: User;
</script>

<TotalRating {user} forSubscribed />

<div class="flex flex-wrap text-sm text-zinc-500 dark:text-zinc-100 gap-1 md:gap-2 items-center">
	<span>@{user?.username}</span>
	<Country {user} />
</div>
