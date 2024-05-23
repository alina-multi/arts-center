<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ArrowRightCircle, ArrowLongRight } from '@steeze-ui/heroicons';
	import WorkPreview from '$lib/components/work/WorkPreview.svelte';
	import { getContext } from 'svelte';
	import WorkModal from '$lib/components/work/WorkModal.svelte';

	const t = getContext('t');
	export let featuredCategories;

	let gallery;
	$: currentOpenWork = null;

	function onClick(workId) {
		gallery = featuredCategories.filter((obj) => obj.works.find((work) => work.id === workId));
		currentOpenWork = workId;
	}
</script>

<section class="container mx-auto px-3 max-sm:mt-6 my-16 space-y-16">
	{#each featuredCategories as category}
		<div>
			<div
				class="mb-6 dark:border-zinc-800 flex items-center justify-between gap-3 tracking-widest"
			>
				<h3
					class=" text-xl border border-zinc-900 dark:bg-zinc-900 dark:border-zinc-800 px-6 py-3 max-sm:w-full"
				>
					{$t(`global.main_page.category.${category.name}`)}
				</h3>

				<a
					href={category.href}
					class="hidden sm:flex items-center gap-3 text-lg hover:text-amber-600"
					>{$t(`global.main_page.view_more`)}
					<Icon src={ArrowRightCircle} class="h-8 w-8 stroke-[1]" />
				</a>
			</div>
			<div
				class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 2xl:grid-cols-6 gap-x-3 gap-y-9 sm:gap-4 lg:max-xl:gap-3 xl:gap-6"
			>
				{#each category.works as work}
					<!-- svelte-ignore a11y-click-events-have-key-events -->
					<!-- svelte-ignore a11y-no-static-element-interactions -->
					<div class="lg:max-2xl:last-of-type:hidden" on:click={() => onClick(work.id)}>
						<WorkPreview {work} loading="eager" />
					</div>
				{/each}
			</div>
			<!-- <a
				href={category.href}
				class="flex   sm:hidden justify-end gap-3 items-center rounded-t-lg tracking-wider text-xl font-medium border-b border-zinc-900 lg:hover:text-amber-600 p-3   mt-9 "
			>
				{$t(`global.main_page.view_more`)}

				
				<Icon src={ArrowRightCircle} class="h-12 w-12 stroke-[1]" />
			</a> -->

			<a href={category.href} class="flex sm:hidden justify-end tracking-wider text-xl mt-9">
				<div class="flex gap-3 items-center px-6 border border-zinc-900 rounded-full dark:bg-zinc-900 dark:border-zinc-700">
					<span>{$t(`global.main_page.view_more`)}</span>

					<Icon src={ArrowLongRight} class="h-10 w-10 stroke-[1]" />
				</div>
			</a>
		</div>
	{/each}
</section>

{#if currentOpenWork}
	<WorkModal gallery={gallery[0].works} />
{/if}
