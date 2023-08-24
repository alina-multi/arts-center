<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { MagnifyingGlass, XMark } from '@steeze-ui/heroicons';
	import SearchBox from './SearchBox.svelte';
	import debounce from 'lodash.debounce';
	import { goto } from '$app/navigation';
	import Loader from '$lib/components/atoms/Loader.svelte';
	import newUniqueId from 'locally-unique-id-generator';
	import { fetchData } from '$lib/helpers/fetchData';


	let value = '';
	let totalUserHits = 0,
		totalWorksHits = 0,
		loading = false;
	$: users = [];
	$: works = [];
	$: open = value.length > 0;
	$: searchValue = '';
	const id = newUniqueId();

	function onEnter(e: KeyboardEvent) {
		if (e.key === 'Enter' && totalWorksHits > 20) {
			open = false;
			goto(`/search/works/${value}`, {
				replaceState: true
			}).then(() => {
				location.reload();
			});
		}
	}

	function inputSearch(e) {
		value = e.target.value.trim();
		searchValue = value;
		if (searchValue.length < 2) return;

		searchValue = searchValue
			.replace(/ /g, '-')
			.replaceAll(/[^a-zA-Z0-9А-ЩЬЮЯҐЄІЇа-щьюяґєії-]/g, '');

		loading = true;
		doSearch(searchValue);
		debounce(doSearch, 600)(searchValue);
	}

	const doSearch = debounce(async (query) => {
		const search = await fetchData(`/api/search/all/${query}/1`);
		users = search.users.hits;
		works = search.works.hits;
		totalUserHits = search.users.totalHits;
		totalWorksHits = search.works.totalHits;
		loading = false;
	}, 600);
</script>

<div
	class="sm:relative w-full mx-3 md:max-lg:w-3/4 2xl:px-16 2xl:w-1/2 xl:w-4/12 md:mx-auto text-gray-900 dark:text-white"
>
	<div class="relative {open ? 'z-50' : 'z-30'} ">
		<span class="sr-only">Search</span>
		<input
			on:input={inputSearch}
			on:keydown={onEnter}
			bind:value
			type="text"
			name="search-{id}"
			id="search-{id}"
			autocomplete="off"
			placeholder="Search..."
			class=" block w-full rounded-full pl-8 py-0.5 dark:bg-zinc-700 dark:border-zinc-700 border-gray-300 border placeholder:text-zinc-400 focus:ring-0 focus:border-gray-500 sm:text-sm sm:leading-6"
		/>
		<div class="absolute inset-y-0 flex z-50 px-2 pt-[5px]">
			<Icon src={MagnifyingGlass} class="text-zinc-400  h-5 w-5" />
		</div>
		{#if loading && value.length > 0}
			<div class="absolute inset-y-0 right-0  z-50 pr-8 py-1">
				<span class="sr-only">Loading...</span>
				<div class="w-6 h-6"><Loader /></div>
			</div>
		{/if}
		{#if open}
			<button
				type="button"
				class="absolute inset-y-0 right-0 flex items-center z-50 px-2"
				aria-label="Clear"
				on:click={() => (value = ' ')}
			>
				<Icon src={XMark} class="text-gray-400 h-5 w-5" />
			</button>
		{/if}
	</div>


	<SearchBox bind:open {users} value={searchValue} {totalUserHits} {totalWorksHits} {works} {loading}/>
</div>
