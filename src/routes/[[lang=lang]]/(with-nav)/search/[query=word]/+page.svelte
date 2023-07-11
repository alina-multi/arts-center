<script lang="ts">
	import { localePath } from '$lib/translations';
	import Picture from '$lib/components/atoms/Picture.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChevronRight } from '@steeze-ui/heroicons';
	import UserDetails from '$lib/components/user/UserDetails.svelte';

	export let data;
	const { search, query } = data;
	let page = 1;
	let newBatch = [];
	$: results = [...search.hits, ...newBatch];
</script>

<ul role="search" class="divide-y divide-gray-100">
	{#each results as user}
		<li class="flex justify-between gap-x-6 py-3">
			<a href={localePath(`/${user.username}`)} class="flex gap-x-4">
				<div class="flex-shrink-0 flex-none rounded-full bg-gray-50 overflow-hidden cursor-pointer">
					<Picture photo={user.photo} size={'w-12 h-12'} />
				</div>

				<div class="min-w-0 flex-auto text-sm ">
					<p class="font-semibold mb-1">{user.name}</p>
					<UserDetails user={user} />
				</div>
			</a>

			<a
				href={localePath(`/${user.username}`)}
				class="cursor-pointer inline-flex gap-3 items-center text-sm text-gray-500 hover:text-sky-500 focus:outline-none focus:underline transition ease-in-out duration-150"
			>
				<span class="hidden sm:block">View profile</span>
				<Icon src={ChevronRight} class="w-6 h-6 text-gray-400" />
			</a>
		</li>
	{/each}
</ul>

<!-- Infinite scroll -->

<!-- const loadMore = async () => {
    page++;
    const res = await fetch(`/api/search/${query}/${page}`);
    const search = await res.json();
    newBatch = search.hits;
}; -->
