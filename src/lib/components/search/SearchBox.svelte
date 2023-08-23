<script lang="ts">
	import { localePath } from '$lib/translations';
	import { Menu, MenuItems, MenuItem } from '@rgossiaux/svelte-headlessui';
	import AvatarLink from '../atoms/AvatarLink.svelte';
	import NoResultsStub from './NoResultsStub.svelte';
	import WorkPreview from '../work/WorkPreview.svelte';


	export let open = false,
		users,
		works,
		totalUserHits: number,
		totalWorksHits: number,
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
			<div class="relative">
				{#if users.length > 0}
					<div
						class="flex items-center justify-between py-3 sm:py-4 px-6 bg-gray-100 dark:bg-zinc-900 sticky top-0 z-10 border-y border-b-gray-200 border-t-gray-100 text-sm font-semibold leading-6 text-gray-900"
					>
						<p class="  font-semibold">
							Found {totalUserHits}
							{users.length === 1 ? 'person' : 'people'}
						</p>
						{#if totalUserHits > 20}
							<a
								data-sveltekit-reload
								href={localePath(`/search/users/${value}`)}
								class="text-blue-700 hover:underline"
							>
								show full results &rarr;
							</a>
						{/if}
					</div>

					<MenuItems class="py-3  border-t dark:border-zinc-800 " static={open}>
						{#each users as user (user.id)}
							<MenuItem
								class="flex gap-3 items-center w-full text-left text-sm px-6 py-1 hover:bg-gray-100 hover:text-gray-900 cursor-pointer dark:hover:bg-zinc-800"
							>
								<AvatarLink {user} size={'h-10 w-10'} withName nameStyles={'text-sm'} />
							</MenuItem>
						{/each}
					</MenuItems>
				{/if}
			</div>


			<div class="relative">
				{#if works.length > 0}
					<div
						class="flex items-center justify-between py-3 sm:py-4 px-6 bg-gray-100 dark:bg-zinc-900 sticky top-0 z-10 border-y border-b-gray-200 border-t-gray-100 text-sm font-semibold leading-6 text-gray-900"
					>
						<p class="  font-semibold">
							Found {totalWorksHits}
							{works.length === 1 ? 'work' : 'works'}
						</p>
						{#if totalWorksHits > 20}
							<a
								data-sveltekit-reload
								href={localePath(`/search/works/${value}`)}
								class="text-blue-700 hover:underline"
							>
								show full results &rarr;
							</a>
						{/if}
					</div>

					<MenuItems class="py-3  border-t dark:border-zinc-800 " static={open}>
						{#each works as work (work.id)}
							<MenuItem
								class="flex gap-3 items-center w-full text-left text-sm px-6 py-1 hover:bg-gray-100 hover:text-gray-900 cursor-pointer dark:hover:bg-zinc-800"
							>
								<WorkPreview {work} />
							</MenuItem>
						{/each}
					</MenuItems>
				{/if}
			</div>

			{#if totalUserHits === 0 && totalWorksHits === 0}
				<NoResultsStub />
			{/if}
		</div>
	{/if}
</Menu>
