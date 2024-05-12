<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChevronRight } from '@steeze-ui/heroicons';
	import WorkPreview from '$lib/components/work/WorkPreview.svelte';
	import { getContext } from 'svelte';
	import WorkModal from '$lib/components/work/WorkModal.svelte';

	const t = getContext('t');
	const locale = getContext('locale');
	export let featuredCategories;

	let gallery;
	$: currentOpenWork = null;

	function onClick(workId) {
		gallery = featuredCategories.filter((obj) => obj.works.find((work) => work.id === workId));
		currentOpenWork = workId;
	}
</script>

<section class="container mx-auto px-3 mt-9 mb-12 space-y-12">
	{#each featuredCategories as category}
		<div>
			<div
				class="mb-6 dark:border-zinc-800 flex items-center justify-between gap-3 tracking-widest"
			>
				<h3 class=" text-xl border border-zinc-900 dark:bg-zinc-900 dark:border-zinc-800 px-6 py-3">
					{$t(`global.main_page.category.${category.name}`)}
				</h3>

				<a href={category.href} class="flex items-center gap-2 text-lg font-medium"
					>{$t(`global.main_page.view_more`)}
					<Icon src={ChevronRight} class="h-8 w-8 stroke-[1]" />
				</a>
			</div>
			<div
				class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-x-3 gap-y-6 sm:gap-4 lg:max-xl:gap-3 xl:gap-6"
			>
				{#each category.works as work, index (work.id)}
					<!-- svelte-ignore a11y-click-events-have-key-events -->
					<!-- svelte-ignore a11y-no-static-element-interactions -->
					<div class="lg:last-of-type:hidden" on:click={() => onClick(work.id)}>
						<WorkPreview {work} loading="eager" />
					</div>
				{/each}
			</div>
		</div>
	{/each}
</section>

{#if currentOpenWork}
	<WorkModal gallery={gallery[0].works} />
{/if}
