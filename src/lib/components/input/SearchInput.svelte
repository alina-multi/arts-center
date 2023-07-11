<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { MagnifyingGlass, XMark } from '@steeze-ui/heroicons';
	import SearchBox from '../SearchBox.svelte';
	import { Spinner } from 'flowbite-svelte';
	import debounce from 'lodash/debounce';
	import { goto } from '$app/navigation';

	let value = '',
		totalHits,
		loading = false,
		results = [];
	$: open = value.length > 0;

	function onEnter(e) {
		if (e.key === 'Enter' && totalHits > 20) {
			open = false;
			goto(`/search/${value}`, {
				replaceState: true
			}).then(() => {
				location.reload();
			});
		}
	}

	const doSearch = debounce((e) => {
		loading = true;
		value = e.target.value;
		fetch(`/api/search/${value}/1`)
			.then((res) => res.json())
			.then((res) => {
				results = [...res.hits];
				totalHits = res.totalHits;
				loading = false;
			});
	}, 600);
</script>

<div
	class="sm:relative w-full mx-3 md:max-lg:w-3/4 2xl:w-1/2 2xl:mx-auto lg:mx-0 md:mx-auto text-gray-900 dark:text-white"
>
	<div class="relative {open ? 'z-50' : 'z-30'} ">
		<span class="sr-only">Search</span>
		<input
			on:input={doSearch}
			on:keydown={onEnter}
			bind:value
			type="text"
			name="search"
			id="search"
			autocomplete="off"
			placeholder="Search..."
			class=" block w-full rounded-full pl-8 py-0.5 dark:bg-zinc-700 dark:border-zinc-700 border-gray-300 border placeholder:text-zinc-400 focus:ring-0 focus:border-gray-500 sm:text-sm sm:leading-6"
		/>
		<div class="absolute inset-y-0 flex z-50 px-2 pt-[5px]">
			<Icon src={MagnifyingGlass} class="text-zinc-400  h-5 w-5" />
		</div>
		{#if loading && value.length > 0}
			<div class="absolute inset-y-0 right-0 flex items-center z-50 pr-8">
				<Spinner color="yellow" size="5" />
			</div>
		{/if}
		{#if open}
			<button
				type="button"
				class="absolute inset-y-0 right-0 flex items-center z-50 px-2"
				aria-label="Clear"
				on:click={() => (value = '')}
			>
				<Icon src={XMark} class="text-gray-400 h-5 w-5" />
			</button>
		{/if}
	</div>

	<SearchBox bind:open {results} {value} {totalHits} />
</div>
