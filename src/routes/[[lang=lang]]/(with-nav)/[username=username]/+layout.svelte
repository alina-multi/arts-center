<script lang="ts">
	import WorkFilters from '$lib/components/user/WorkFilters.svelte';
	import type { PageData } from './$types';
	import UserCard from '$lib/components/user/UserCard.svelte';
	import Biography from '$lib/components/user/Biography.svelte';

	export let data: PageData;
	let userTags = data.user.ratings.map((rating) => rating.tag);
</script>

<div class="flex flex-col xl:flex-row gap-3 mt-3">
	<div
		class=" xl:w-1/4 rounded-md border shadow-sm dark:bg-zinc-900 dark:border-zinc-800 dark:border-transparent h-min xl:min-h-screen"
	>
		<UserCard user={data.user} />
	</div>

	<div class="flex flex-col gap-3 xl:w-3/4">
		{#if userTags.length > 0}
			<div class="w-full relative"><WorkFilters tags={userTags} params={data.params} /></div>
		{/if}
		<Biography user={data.user} />

		<slot />
	</div>
</div>
