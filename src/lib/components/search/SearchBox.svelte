<script lang="ts">
	import { localePath } from '$lib/translations';
	import { Menu, MenuItems, MenuItem } from '@rgossiaux/svelte-headlessui';
	import Avatar from '../atoms/Avatar.svelte';
	import cat from '$lib/images/cat-icons.svg';

	export let open = false,
		results = [],
		totalHits: number,
		value = '';
</script>

<Menu class=" flex-1 block mx-3 xl:mx-9 ">
	{#if open}
		<!-- svelte-ignore a11y-click-events-have-key-events -->
		<!-- svelte-ignore a11y-no-static-element-interactions -->
		<div
			on:click|self={() => (open = false)}
			class="lg:fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity z-40"
		/>

		<div
			class=" absolute z-50 top-20 sm:top-16 lg:top-12 left-0 w-full text-gray-900 dark:text-zinc-300 bg-white dark:bg-zinc-900 shadow-lg sm:rounded-md max-h-[500px] overflow-scroll overscroll-none dark:border dark:border-zinc-800"
		>
			{#if results.length > 0}
				<div
					class="flex items-center justify-between py-3 sm:py-4 px-6 bg-gray-100 dark:bg-zinc-900"
				>
					<p class="  font-semibold">
						Found {totalHits}
						{results.length === 1 ? 'person' : 'people'}
					</p>
					{#if totalHits > 20}
						<a
							data-sveltekit-reload
							href={localePath(`/search/${value}`)}
							class="text-blue-700 hover:underline"
						>
							show full results &rarr;
						</a>
					{/if}
				</div>
				<MenuItems class="py-3  border-t dark:border-zinc-800 " static={open}>
					{#each results as user}
						<MenuItem>
							<a
								on:click={() => (open = false)}
								href={localePath(`/${user.username}`)}
								class="flex gap-3 items-center w-full text-left text-sm px-6 py-1 hover:bg-gray-100 hover:text-gray-900 cursor-pointer dark:hover:bg-zinc-800"
							>
								<Avatar {user} size={'h-10 w-10'} withName nameStyles={'text-sm'} />
							</a>
						</MenuItem>
					{/each}
				</MenuItems>
			{/if}
			{#if totalHits === 0}
				<div class="p-6 flex flex-col items-center">
					<div class="w-24">
						<svg class="h-24 w-24 text-gray-400 dark:fill-zinc-400">
							<use href="{cat}#icon-cat-with-ball" />
						</svg>
					</div>
					<p class="mt-4 text-sm text-gray-900 dark:text-zinc-400">
						No people found using that search term.
					</p>
				</div>
			{/if}
		</div>
	{/if}
</Menu>
