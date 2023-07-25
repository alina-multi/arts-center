<script lang="ts">
	import { localePath } from '$lib/translations';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChevronRight } from '@steeze-ui/heroicons';
	import UserDetails from '$lib/components/user/UserDetails.svelte';
	import InfiniteScroll from '$lib/components/atoms/InfiniteScroll.svelte';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import cat from '$lib/images/cat-icons.svg';

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


{#if results.length > 0}
<div
	class="lg:w-3/4 mx-auto dark:lg:bg-zinc-900 pt-3 lg:border dark:border-0 border-t-transparent mb-3"
>
	<ul role="search" class="lg:divide-y divide-gray-100 dark:lg:divide-zinc-800">
		{#each results as user}
			<li class="flex justify-between gap-x-6 py-3 lg:px-9">
				<div class=" flex gap-3 w-full sm:max-w-max">
					<Avatar {user} size={'h-12 w-12'} />

					<a href={localePath(`/${user.username}`)} class=" min-w-0 flex-auto text-sm">
						<div class="font-semibold mb-1 cursor-pointer hover:underline">{user.name}</div>
						<UserDetails {user} />
					</a>
				</div>

				<a
					href={localePath(`/${user.username}`)}
					class="cursor-pointer hidden sm:inline-flex gap-3 items-center text-sm text-zinc-500 hover:scale-105 hover:text-gray-600 transition ease-in-out duration-150"
				>
					<span>View profile</span>
					<Icon src={ChevronRight} class="w-6 h-6 " />
				</a>
			</li>
		{/each}

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
</div>
{:else}
<div class="space-y-9 my-16">
	<div class="w-72 h-72 mx-auto">
		<svg class="h-72 fill-zinc-700 dark:fill-zinc-400">
			<use href="{cat}#icon-cat" />
		</svg>
	</div>
	
	<p class= "text-3xl text-center text-zinc-700 dark:text-zinc-400 pl-9">No results found</p>
</div>
{/if}
