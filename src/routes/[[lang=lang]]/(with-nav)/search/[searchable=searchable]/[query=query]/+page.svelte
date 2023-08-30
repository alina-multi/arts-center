<script lang="ts">
	import { localePath, t } from '$lib/translations';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChevronRight } from '@steeze-ui/heroicons';
	import InfiniteScroll from '$lib/components/atoms/InfiniteScroll.svelte';
	import NoResultsStub from '$lib/components/search/NoResultsStub.svelte';
	import UserPreview from '$lib/components/user/UserPreview.svelte';
	import SideMenu from '$lib/components/nav/side/SideMenu.svelte';
	import SearchFilters from '$lib/components/search/SearchFilters.svelte';
	import WorkPreview from '$lib/components/work/WorkPreview.svelte';
	import { fetchData } from '$lib/helpers/fetchData';

	export let data;
	let searchable = data.params.searchable;
	$: query = data.params.query;
	let page = 1;
	$: newBatch = [];
	$: hasMore = true;
	let loading = false;

	$: results = data.search[searchable].hits;

	$: if (data.params.searchable !== searchable) {
		searchable = data.params.searchable;
		hasMore = true;
		newBatch = [];
		page = 1;
	}

	async function loadMore() {
		loading = true;
		const search = await fetchData(`/api/search/${searchable}/${query}/${page}`);

		newBatch = search.hits;
		results = [...results, ...newBatch];

		if (newBatch.length !== 20) {
			hasMore = false;
		}
		loading = false;
	}
</script>

<SideMenu>
	<slot />
	<svelte:fragment slot="nav">
		<SearchFilters
			query={data.params.query}
			options={[
				{ title: 'people', total: data.search.users.totalHits, path: 'users' },
				{ title: 'works', total: data.search.works.totalHits, path: 'works' }
			]}
		/>
	</svelte:fragment>
	{#if results.length > 0}
		{#if data.params.searchable === 'users'}
			<div class="  dark:lg:bg-zinc-900 pt-3 lg:border dark:border-0 mb-3">
				<ul role="search" class="lg:divide-y divide-gray-100 dark:lg:divide-zinc-800">
					{#each results as user}
						<li class="flex justify-between gap-x-6 py-3 lg:px-9">
							<div><UserPreview {user} avatar_size={'w-12 h-12'} crown_size={'w-3 h-3'} /></div>

							<a
								href={localePath(`/${user.username}`)}
								class="cursor-pointer hidden sm:inline-flex gap-3 flex-0 items-center text-sm text-zinc-500 hover:scale-105 hover:text-gray-600 transition ease-in-out duration-150"
							>
								<span> {$t('global.search.view_profile')}</span>
								<Icon src={ChevronRight} class="w-6 h-6 " />
							</a>
						</li>
					{/each}
				</ul>
			</div>
		{/if}

		{#if data.params.searchable === 'works'}
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 justify-center items-center gap-3">
				{#each results as work}
					<WorkPreview {work} />
				{/each}
			</div>
		{/if}

		{#if hasMore}
			<InfiniteScroll
				{hasMore}
				{loading}
				on:loadMore={() => {
					page++;
					loadMore();
				}}
			/>
		{/if}
	{/if}

	{#if results.length === 0}
		<NoResultsStub />
	{/if}
</SideMenu>
