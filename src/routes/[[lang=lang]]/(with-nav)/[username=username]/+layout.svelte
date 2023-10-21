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

<div class="container mx-auto gap-6 px-3 flex flex-col xl:flex-row mt-6 dark:text-white mb-6">
	<div class=" xl:w-4/12 space-y-6 flex flex-col items-center w-full">
		<UserCard user={data.user} />

		<div class="flex max-md:flex-col xl:flex-col items-start gap-6 w-full justify-center">
			<DonateForm />
			<div
				class="border w-full dark:bg-zinc-900 rounded-sm dark:border-zinc-800 py-6 px-6 xs:px-9 sm:w-3/4 sm:max-md:mx-auto md:w-1/2 md:px-6 xl:w-full space-y-2"
			>
				<TotalRating user={data.user} />

				<RatingTags user={data.user} />
			</div>
		</div>
	</div>
	<main class="flex flex-col gap-6 xl:pl-3 xl:w-8/12">
		{#if userTags.length > 0}
			<div class="w-full relative"><WorkFilters tags={userTags} params={data.params} /></div>
		{/if}
		<Biography user={data.user} />
		<slot />
	</main>
</div>
