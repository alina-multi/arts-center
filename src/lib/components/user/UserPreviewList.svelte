<script lang="ts">
	import UserPreview from '$lib/components/user/UserPreview.svelte';
	import LastWorks from '$lib/components/atoms/LastWorks.svelte';
	import type { UserPreview as Users } from '$lib/interfaces/User.ts';
	import UsersFilters from '$lib/components/filters/UsersFilters.svelte';
	import InfiniteScroll from '$lib/components/atoms/InfiniteScroll.svelte';
	import { localePath } from '$lib/translations';
	import * as devalue from 'devalue';
	import SideMenu from '$lib/components/nav/side/SideMenu.svelte';
	import cat from '$lib/images/cat-icons.svg';

	export let users: Users[], categories, countries, params;

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

<SideMenu>
	<svelte:fragment slot="nav"
		><UsersFilters tags={categories} {countries} {params} /></svelte:fragment
	>
	{#if users.length === 0}
		<div
			class="flex flex-col items-center py-6 border rounded-md dark:bg-zinc-900 dark:border-zinc-800"
		>
			<p class="text-gray-500 dark:text-zinc-300 text-xl font-semibold">No results found</p>
			<svg class="h-64 w-64 fill-zinc-800 dark:fill-zinc-300">
				<use href="{cat}#icon-cat-not-found" />
			</svg>
		</div>
	{:else}
		{#each users as user}
			<div
				class="flex flex-col items-center sm:flex-row sm;gap-3 shadow-sm border rounded-md w-full dark:bg-zinc-900 dark:border-zinc-800 {user.subscribed
					? 'bg-zinc-50 dark:bg-blue-900 shadow-2xl'
					: 'bg-white'}"
			>
				<div
					class=" flex items-center grow w-full sm:w-1/2 text-lg px-3 sm:max-lg:pt-3 py-3 gap-3 overflow-hidden"
				>
					<UserPreview {user} />
				</div>
				<div
					class=" sm:p-3 lg:p-0 flex justify-end sm:w-1/2 dark:border-gray-700 gap-3 overflow-hidden w-full"
				>
					<LastWorks works={user.works} />
				</div>
			</div>
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
