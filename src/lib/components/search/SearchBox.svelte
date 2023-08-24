<script lang="ts">
	import { Menu, MenuItems, MenuItem } from '@rgossiaux/svelte-headlessui';
	import AvatarLink from '../atoms/AvatarLink.svelte';
	import NoResultsStub from './NoResultsStub.svelte';
	import WorkPreview from '../work/WorkPreview.svelte';
	import BoxHeader from './BoxHeader.svelte';

	export let open = false,
		users,
		works,
		loading: boolean,
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
			class="h-screen md:max-h-[600px] md:h-fit absolute z-50 top-20 sm:top-16 lg:top-12 left-0 w-full text-gray-900 dark:text-zinc-300 bg-white dark:bg-black shadow-lg sm:rounded-md  overflow-scroll overscroll-none md:dark:border dark:border-zinc-800"
		>
			<div class="relative">
				{#if users.length > 0}
					<BoxHeader total={totalUserHits} href={`/search/users/${value}`}>
						Found {totalUserHits}
						{users.length === 1 ? 'person' : 'people'}
					</BoxHeader>

					<MenuItems class="py-2 border-b dark:border-b-zinc-800" static={open}>
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
					<BoxHeader total={totalWorksHits} href={`/search/works/${value}`}>
						Found {totalWorksHits}
						{works.length === 1 ? 'work' : 'works'}
					</BoxHeader>

					<MenuItems class="py-2  border-b dark:border-zinc-800 divide-y dark:divide-zinc-800 flex flex-col justify-center" static={open}>
						{#each works as work (work.id)}
							<MenuItem class="p-6 ">
								<WorkPreview {work} />
							</MenuItem>
						{/each}
					</MenuItems>
				{/if}
			</div>

			{#if totalUserHits === 0 && totalWorksHits === 0 && !loading && value.length > 2}
				<NoResultsStub />
			{/if}

			{#if value.length < 2}
				<div>
					<p class="text-center text-gray-500 dark:text-zinc-400 text-sm py-4">
						Please enter at least 2 characters
					</p>
				</div>
			{/if}
		</div>
	{/if}
</Menu>
