<script lang="ts">
	import UserPreview from '$lib/components/user/UserPreview.svelte';
	import LastWorks from '$lib/components/atoms/LastWorks.svelte';
	import type { UserPreview as Users } from '$lib/interfaces/User.ts';
	import UsersFilters from '$lib/components/user/UsersFilters.svelte';
	import InfiniteScroll from '$lib/components/atoms/InfiniteScroll.svelte';
	import { localePath } from '$lib/translations';
	import * as devalue from 'devalue';
	import SideManu from '$lib/components/nav/side/SideManu.svelte';

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

<SideManu>
	<svelte:fragment slot="nav"
		><UsersFilters tags={categories} {countries} {params} /></svelte:fragment
	>
	{#each users as user (user.id)}
		<div
			class="flex flex-col items-center sm:flex-row gap-3 shadow-sm border rounded-md w-full dark:bg-zinc-900 dark:border-zinc-800 {user.subscribed
				? 'bg-zinc-50 dark:bg-blue-900 shadow-2xl'
				: 'bg-white'}"
		>
			<div
				class=" flex items-center grow w-full sm:w-1/2 text-lg px-3 max-lg:pt-3 sm:max-lg:pb-3 gap-3 overflow-hidden"
			>
				<UserPreview {user} />
			</div>
			<div
				class="px-3 pb-3 sm:p-3 lg:p-0 flex justify-end sm:w-1/2 dark:border-gray-700 gap-3 overflow-hidden"
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
</SideManu>
