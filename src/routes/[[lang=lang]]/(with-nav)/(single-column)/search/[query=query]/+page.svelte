<script lang="ts">
	import { localePath } from '$lib/translations';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChevronRight } from '@steeze-ui/heroicons';
	import UserDetails from '$lib/components/user/UserDetails.svelte';
	import InfiniteScroll from '$lib/components/atoms/InfiniteScroll.svelte';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
import NoResultsStub from '$lib/components/search/NoResultsStub.svelte';
import UserPreview from '$lib/components/user/UserPreview.svelte';


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
					<div><UserPreview {user} avatar_size={'w-12 h-12'} crown_size={'w-3 h-3'} /></div>
					
					<a
						href={localePath(`/${user.username}`)}
						class="cursor-pointer hidden sm:inline-flex gap-3 flex-0 items-center text-sm text-zinc-500 hover:scale-105 hover:text-gray-600 transition ease-in-out duration-150"
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
	<NoResultsStub />
{/if}
