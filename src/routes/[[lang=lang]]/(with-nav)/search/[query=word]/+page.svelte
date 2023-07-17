<script lang="ts">
	import { localePath } from '$lib/translations';
	import Picture from '$lib/components/atoms/Picture.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChevronRight } from '@steeze-ui/heroicons';
	import UserDetails from '$lib/components/user/UserDetails.svelte';
	import InfiniteScroll from '$lib/components/atoms/InfiniteScroll.svelte';

	export let data;
	const { search, query } = data;
	let page = 1;
	let newBatch = [];
	let loading = false;
	let hasMore = true;
	$: results = [...search.hits];

	async function fetchData() {
		loading = true;
		let url = localePath(`/api/search/${query}/${page}`);
		const response = await fetch(url);
		const search = await response.json();
		newBatch = search.hits;
		results = [...results, ...newBatch];

		if (newBatch.length !== 20) {
			hasMore = false;
		}
		loading = false;
	}
</script>

<ul role="search" class="divide-y divide-gray-100">
	{#each results as user}
		<li class="flex justify-between gap-x-6 py-3">
			<a href={localePath(`/${user.username}`)} class="flex gap-x-4">
				<div class="flex-shrink-0 flex-none rounded-full bg-gray-50 overflow-hidden cursor-pointer">
					<Picture photo={user.photo} size={'w-12 h-12'} />
				</div>

				<div class="min-w-0 flex-auto text-sm">
					<p class="font-semibold mb-1">{user.name}</p>
					<UserDetails {user} />
				</div>
			</a>

			<a
				href={localePath(`/${user.username}`)}
				class="cursor-pointer inline-flex gap-3 items-center text-sm text-gray-500 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150"
			>
				<span class="hidden sm:block">View profile</span>
				<Icon src={ChevronRight} class="w-6 h-6 text-gray-400" />
			</a>
		</li>
	{/each}

	<div />
	{#if hasMore}
		<InfiniteScroll
			{hasMore}
			{loading}
			on:loadMore={() => {
				page++;
				fetchData();
			}}
		/>
	{/if}
</ul>
