<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { MagnifyingGlass, XMark } from '@steeze-ui/heroicons';
	import SearchBox from './SearchBox.svelte';
	import debounce from 'lodash.debounce';
	import { goto } from '$app/navigation';
	import Loader from '$lib/components/atoms/Loader.svelte';
	import newUniqueId from 'locally-unique-id-generator';
	import { getData } from '$lib/helpers/getData';
	import { t } from '$lib/translations';
	import { slug } from '$lib/helpers/url';

	let value = '';
	let totalUserHits = 0,
		totalWorksHits = 0,
		loading = false;
	$: users = [];
	$: works = [];
	$: open = value.length > 0;
	$: searchValue = '';
	const id = newUniqueId();

	function redirectToSearchPage(searchable: string) {
		open = false;
		goto(`/search/${searchable}/${searchValue}`, {
			replaceState: true
		}).then(() => {
			location.reload();
		});
	}

	function onEnter(e: KeyboardEvent) {
		if (e.key === 'Enter') {
			if (totalUserHits > 0) {
				redirectToSearchPage('users');
				return;
			}

			if (totalWorksHits > 0) {
				redirectToSearchPage('works');
				return;
			}
		}
	}

	function inputSearch(e) {
		value = e.target.value.trim();
		searchValue = value;
		if (searchValue.length < 2) return;

		searchValue = slug(searchValue);

		loading = true;
		doSearch(searchValue);
		debounce(doSearch, 600)(searchValue);
	}

	const doSearch = debounce(async (query) => {
		const search = await getData(`/api/search/all/${query}/1`);
		users = search.users.hits.slice(0, 6);
		works = search.works.hits.slice(0, 6);
		totalUserHits = search.users.totalHits;
		totalWorksHits = search.works.totalHits;
		loading = false;
	}, 600);
</script>

<div
	class="sm:relative w-full mx-3 2xl:px-16 2xl:w-1/2  xl:px-3 xl:w-[426px] xl:flex-none md:mx-auto text-gray-900 dark:text-white"
>
	<div class="relative {open ? 'z-50' : 'z-30'} ">
		<span class="sr-only">{$t('global.search.placeholder')}</span>
		<input
			on:input={inputSearch}
			on:keydown={onEnter}
			bind:value
			type="text"
			name="search-{id}"
			id="search-{id}"
			autocomplete="off"
			placeholder="{$t('global.search.placeholder')}..."
			class=" block w-full rounded-sm pl-8 py-0.5 dark:bg-zinc-700 dark:border-zinc-700 border-gray-300 border placeholder:text-zinc-400 focus:ring-0 focus:border-gray-500 sm:text-sm sm:leading-6"
		/>
		<div class="absolute inset-y-0 flex z-50 px-2 pt-[5px]">
			<Icon src={MagnifyingGlass} class="text-zinc-400  h-5 w-5" />
		</div>
		{#if loading && value.length > 0}
			<div class="absolute inset-y-0 right-0 z-50 pr-8 py-1">
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

	<SearchBox
		bind:open
		{users}
		value={searchValue}
		{totalUserHits}
		{totalWorksHits}
		{works}
		{loading}
	/>
</div>
