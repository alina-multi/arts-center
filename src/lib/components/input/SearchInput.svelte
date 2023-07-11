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

<div class="sm:relative w-full mx-3 md:max-lg:w-3/4  lg:mx-0 md:mx-auto text-gray-900 dark:text-white">
	<div class="relative  {open ? 'z-50': 'z-30'}">
		<span class="sr-only">Search</span>
		<input
			on:input={(e) => debounce(e.target.value)}
			bind:value
			type="text"
			name="search"
			id="search"
			autocomplete="off"
			placeholder="Search..."
			class=" block w-full rounded-full pl-8 py-0.5  dark:bg-zinc-700 dark:border-zinc-700 border-gray-300 border placeholder:text-zinc-400 focus:ring-0 focus:border-gray-500 sm:text-sm sm:leading-6"
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



	<SearchBox {open} {results} {value} {totalHits} />

	
</div>
