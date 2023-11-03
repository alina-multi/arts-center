<script lang="ts">
	import type { UserPreview as Users } from '$lib/interfaces/User.ts';
	import UsersFilters from '$lib/components/filters/UsersFilters.svelte';
	import InfiniteScroll from '$lib/components/atoms/InfiniteScroll.svelte';
	import { localePath, t } from '$lib/translations';
	import {parse} from 'devalue';
	import SideMenu from '$lib/components/nav/side/SideMenu.svelte';
	import cat from '$lib/images/cat-icons.svg';
	import UserPreviewWithWorks from '$lib/components/user/UserPreviewWithWorks.svelte';

	export let users: Users[], categories, countries, params;

	let newBatch = [];
	$: page = 1;
	let loading = false;
	let hasMore = true;

	$: users = [...users, ...newBatch];

	async function fetchData() {
		
		loading = true;
		let url = localePath(`/api/users/${params.order}/${params.category}/${params.country}/${page}`);
		const response = await fetch(url);
		const text = await response.text();
		const data = parse(text);
		newBatch = data.users;
		if (newBatch.length < 10) {
			hasMore = false;
		}
		loading = false;
	}
</script>

<SideMenu>
	<svelte:fragment slot="nav"
		><UsersFilters tags={categories} {countries} {params} /></svelte:fragment
	>
	{#if users.length === 0}
		<div
			class="flex flex-col items-center py-6 border rounded-sm dark:bg-zinc-900 dark:border-zinc-800"
		>
			<p class="text-gray-500 dark:text-zinc-300 text-xl font-semibold">{$t('global.filters.no_results')}</p>
			<svg class="h-64 w-64 fill-zinc-800 dark:fill-zinc-300">
				<use href="{cat}#icon-cat-not-found" />
			</svg>
		</div>
	{:else}
		{#each users as user (user.id)}
			<UserPreviewWithWorks {user}/>
		{/each}
		<InfiniteScroll
			{hasMore}
			{loading}
			on:loadMore={() => {
				page++;
				fetchData();
			}}
		/>
	{/if}
</SideMenu>
