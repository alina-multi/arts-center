<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { MagnifyingGlass, XMark } from '@steeze-ui/heroicons';
	import SearchBox from '../SearchBox.svelte';
	import { Spinner } from 'flowbite-svelte';

	let value = '',
		totalHits,
		timer,
		listener,
		loading = false;
	let results = [];
	$: open = value.length > 0;

	const fetchData = async (url) => {
		let res = await fetch(url).then((res) => res.json());
		results = [...res.hits];
		totalHits = res.totalHits;
	};

	const debounce = (value) => {
		loading = true;
		clearTimeout(timer);
		timer = setTimeout(() => {
			fetchData(`/api/search/${value}/1`);
			loading = false;
		}, 750);
	};

	function handleClickOutside(event) {
		if (event.target.id !== 'search' && event.target.id !== 'searchList') {
			open = '';
		}
	}

	$: if (open) {
		window.addEventListener('click', handleClickOutside);
		listener = true;
	}
	$: if (!open && listener) {
		window.removeEventListener('click', handleClickOutside);
	}
</script>

<SearchBox {open} {results} {value} {totalHits}>
	<span class="sr-only">Search</span>
	<input
		on:input={(e) => debounce(e.target.value)}
		bind:value
		type="text"
		name="search"
		id="search"
		autocomplete="off"
		placeholder="Search..."
		class=" relative z-50 block w-full rounded-full border-0 pl-9 py-1 text-gray-900 shadow-sm ring-1 ring-gray-200 placeholder:text-gray-400 focus:ring-gray-400 sm:text-sm sm:leading-6"
	/>
	<div class="absolute inset-y-0 flex z-50 px-2 pt-1.5">
		<Icon src={MagnifyingGlass} class="text-gray-400 h-5 w-5" />
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
</SearchBox>
