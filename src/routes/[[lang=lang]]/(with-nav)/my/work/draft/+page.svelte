<script lang="ts">
	import type { PageData } from './$types';
	import DraftPreview from '$lib/components/work/DraftPreview.svelte';
	import HeaderLayout from '$lib/components/my/HeaderLayout.svelte';
	import { t } from '$lib/translations';

	export let data: PageData;
</script>

<HeaderLayout title={$t('my.drafts')}>
	<div slot="details" class="flex gap-3 items-center leading-3">
		<div class="h-1 w-1 bg-gray-500 dark:bg-zinc-300 rounded-full" />
		<span
			>{data.gallery.length}
			{data.gallery.length === 1 ? $t('my.work') : $t('my.works')}
		</span>
	</div>
</HeaderLayout>
{#if data.gallery.length > 0}
	<ul class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-3">
		{#each data.gallery as draft}
			<li class="relative rounded-sm overflow-hidden">
				<DraftPreview {draft} />
			</li>
		{/each}
	</ul>
{:else}
	<div
		class="border-x -mt-4 border-b dark:border-t rounded-b-sm dark:border-zinc-800 dark:bg-zinc-900"
	>
		<p class="p-6">{$t('my.no_drafts')}</p>
	</div>
{/if}
