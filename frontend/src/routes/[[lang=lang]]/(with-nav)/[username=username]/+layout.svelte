<script lang="ts">
	import WorkFilters from '$lib/components/filters/WorkFilters.svelte';
	import type { PageData } from './$types';
	import UserCard from '$lib/components/user/UserCard.svelte';
	import Biography from '$lib/components/user/Biography.svelte';

	import DonateForm from '$lib/components/atoms/DonateForm.svelte';
	import TotalRating from '$lib/components/user/TotalRating.svelte';
	import RatingTags from '$lib/components/user/RatingTags.svelte';

	export let data: PageData;
	let userTags = data.user.ratings.map((rating) => rating.tag);
</script>

<main class="lg:container mx-auto gap-6 px-3 xl:flex xl:flex-row mt-6 dark:text-white">
	<div class=" xl:w-4/12 space-y-6 md:w-3/4 lg:max-xl:w-2/3 sm:max-xl:mx-auto mb-6">
		<UserCard user={data.user} />

		{#if data.user.ratings?.length}
			<div class="w-full dark:bg-zinc-950 shrink-0 border dark:border-zinc-800 space-y-3">
				<TotalRating user={data.user} />
				<RatingTags user={data.user} />
			</div>
		{/if}

		{#if data.user.verified_at}
			<DonateForm user={data.user} />
		{/if}
	</div>

	<div class="flex flex-col gap-6 xl:pl-3 xl:w-8/12">
		{#if userTags.length > 0}
			<div class="w-full relative"><WorkFilters tags={userTags} params={data.params} /></div>
		{/if}
		<Biography user={data.user} />
		<slot />
	</div>
</main>
