<script lang="ts">
	import { Menu } from '@rgossiaux/svelte-headlessui';
	import AvatarLink from '../atoms/AvatarLink.svelte';
	import NoResultsStub from './NoResultsStub.svelte';
	import WorkPreview from '../work/WorkPreview.svelte';
	import BoxHeader from './BoxHeader.svelte';
	import { getContext } from 'svelte';

	const t = getContext('t');

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
			class="h-screen md:max-h-[600px] md:h-fit absolute z-50 top-20 sm:top-16 lg:top-12 left-0 w-full text-black dark:text-zinc-300 bg-white dark:bg-black shadow-lg sm:rounded-sm overflow-scroll overscroll-none md:dark:border dark:border-zinc-800"
		>
			<div class="relative">
				{#if users.length > 0}
					<BoxHeader total={totalUserHits} href={`/search/users/${value}`}>
						{$t('global.search.results.found')}
						{totalUserHits}
						{users.length === 1
							? $t('global.search.results.person')
							: $t('global.search.results.people')}
					</BoxHeader>

					<ul class="py-2 border-b dark:border-b-zinc-800">
						<!-- svelte-ignore a11y-no-static-element-interactions -->
						{#each users as user (user.id)}
							<!-- svelte-ignore a11y-click-events-have-key-events -->
							<div
								on:click={() => (open = false)}
								class="flex gap-3 items-center w-full text-left text-sm px-6 py-1.5 hover:bg-gray-100 hover:text-black cursor-pointer dark:hover:bg-zinc-800"
							>
								<AvatarLink
									{user}
									size={'h-10 w-10'}
									withName
									nameStyles={'text-sm '}
									width={'w-full'}
								/>
							</div>
						{/each}
					</ul>
				{/if}
			</div>

			<div class="relative">
				{#if works.length > 0}
					<BoxHeader total={totalWorksHits} href={`/search/works/${value}`}>
						{$t('global.search.results.found')}
						{totalWorksHits}
						{works.length === 1
							? $t('global.search.results.work')
							: $t('global.search.results.works')}
					</BoxHeader>

					<ul
						class="py-3 gap-6 lg:gap-3 px-3 md:max-lg:grid-cols-3 sm:grid sm:grid-cols-2 2xl:grid-cols-3 border-b dark:border-zinc-800 max-xl:divide-y dark:divide-zinc-800 flex flex-col justify-center"
					>
						<!-- svelte-ignore a11y-no-noninteractive-element-interactions -->
						{#each works as work (work.id)}
							<!-- svelte-ignore a11y-click-events-have-key-events -->
							<li on:click={() => (open = false)}>
								<WorkPreview {work} />
							</li>
						{/each}
					</ul>
				{/if}
			</div>

			{#if totalUserHits === 0 && totalWorksHits === 0 && !loading && value.length > 2}
				<NoResultsStub />
			{/if}

			{#if value.length < 2}
				<div>
					<p class="text-center text-gray-500 dark:text-zinc-400 text-sm py-4">
						{$t('global.search.stub_at_least')}
					</p>
				</div>
			{/if}
		</div>
	{/if}
</Menu>
