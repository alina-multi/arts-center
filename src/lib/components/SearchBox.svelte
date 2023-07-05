<script lang="ts">
	import { localePath } from '$lib/translations';
	import { Menu, MenuItems, MenuItem } from '@rgossiaux/svelte-headlessui';
	export let open = false,
		results = [],
		totalHits,
		value = '';
</script>

<Menu class="mt-2  flex-1 ">
	<div class=" px-12">
		<div class="relative w-full">
			<slot />
			{#if open}
				<div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity z-40 " />

				<div
					class="absolute top-12 left-0 w-full bg-white shadow-lg z-40 rounded-md "
					id="searchList"
				>
					{#if results.length > 0}
						<p class="block w-fulltext-sm text-gray-700 mt-3 py-2 px-6 font-semibold">
							Found {totalHits}
							{results.length === 1 ? 'person' : 'people'}
						</p>
						<MenuItems class="py-3  border-t" static={open}>
							{#each results as user}
								<MenuItem let:active>
									<a
										href={localePath(`/${user.username}`)}
										class="block w-full text-left text-sm px-6 py-1 text-gray-700 hover:bg-gray-100 hover:text-gray-900 cursor-pointer select-none rounded-md {active
											? 'bg-gray-100 text-gray-900'
											: ''}"
									>
										{user.name}
									</a>
								</MenuItem>
							{/each}
							<MenuItem>
								<a data-sveltekit-reload
									href={localePath(`/search/${value}`)}
									class="block w-full text-left text-sm border-t mt-3 text-gray-700 hover:bg-gray-100 hover:text-gray-900 py-2 px-6 cursor-default select-none font-semibold"
								>
									Show full search results
								</a></MenuItem
							>
						</MenuItems>
					{/if}
					{#if totalHits === 0}
						<div class="pb-3 text-center">
							<!-- Sad Cat Icon -->
							<p class="mt-4 text-sm text-gray-900">No people found using that search term.</p>
						</div>
					{/if}
				</div>
			{/if}
		</div>
	</div>
</Menu>
