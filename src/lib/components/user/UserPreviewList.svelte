<script lang="ts">
	import UserPreviewRegular from '$lib/components/user/UserPreviewRegular.svelte';
	import UserPreviewPremium from '$lib/components/user/UserPreviewPremium.svelte';
	import LastWorks from '$lib/components/atoms/LastWorks.svelte';
	import type { UserPreview } from '$lib/interfaces/User.ts';
	import UsersFilters from '$lib/components/user/UsersFilters.svelte';
	import InfiniteScroll from '$lib/components/atoms/InfiniteScroll.svelte';
	import { localePath } from '$lib/translations';
	import * as devalue from 'devalue';

	export let users: UserPreview[], categories, countries, params;

	let newBatch = [];
	let page = params.page;
	let loading = false;
	let hasMore = true;
	$: users = [...users, ...newBatch];

	async function fetchData() {
		loading = true;
		let url = localePath(`/api/users/${params.order}/${params.category}/${params.country}/${page}`);
		const response = await fetch(url);
		const text = await response.text();
		const data = devalue.parse(text);
		newBatch = data.users;
		if (newBatch.length < 10) {
			hasMore = false;
		}
		loading = false;
	}
</script>

<div class="flex flex-col xl:flex-row max-xl:gap-3 mt-3 dark:text-white">
	<div class="xl:w-3/12 border dark:bg-zinc-900 dark:border-zinc-800  rounded-md">
		<UsersFilters tags={categories} {countries} {params} />
	</div>
	<div class="flex flex-col gap-3 xl:pl-3 xl:w-9/12">
		{#each users as user (user.id)}
			{#if user.subscribed}
				<UserPreviewPremium {user} />
			{:else}
				<div
					class="flex flex-col items-center sm:flex-row gap-3 shadow-sm border rounded-md w-full dark:bg-zinc-900 dark:border-zinc-800"
				>
					<div
						class=" flex items-center grow w-full sm:w-1/2 text-lg px-3 pt-3 sm:pb-3 gap-3 overflow-hidden"
					>
						<UserPreviewRegular {user} />
					</div>
					<div
						class="px-3 pb-3 sm:p-3 lg:p-0 flex justify-end sm:w-1/2 dark:border-gray-700 gap-3 overflow-hidden"
					>
						<LastWorks works={user.works} />
					</div>
				</div>
			{/if}
		{/each}
		<InfiniteScroll
			{hasMore}
			{loading}
			on:loadMore={() => {
				page++;
				fetchData();
			}}
		/>
	</div>
</div>
