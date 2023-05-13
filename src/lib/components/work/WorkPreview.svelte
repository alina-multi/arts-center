<script lang="ts">
	import RatingPreview from '$lib/components/rating/RatingPreview.svelte';
	import UserPreviewInline from '$lib/components/user/UserPreviewInline.svelte';
	import type { Work } from '$lib/interfaces/Work';

	import ImageWork from '$lib/components/atoms/ImageWork.svelte';

	export let work: Work;
</script>

<li
	class="flex flex-col overflow-hidden lg:w-80 md:w-[23rem] xl:w-[19rem] 2xl:w-[18rem] {work.subscribed
		? ' '
		: ''} "
>
	<div class="group/item relative">
		<ImageWork {work} withDesription />
		<div
			class="group/edit hidden group-hover/item:block absolute top-3 right-3 text-white bg-black/50 pt-1 px-1 transition-all rounded-md"
		>
			<RatingPreview rating={work.rating} comments={work.comments} />
		</div>
	</div>

	<div class="flex justify-between items-center text-xs text-gray-500 mt-auto">
		{#each work.owners as user}
			<UserPreviewInline {user} />
		{/each}

		{#if work.subscribed}
			<span
				class="mr-2 shadow-md text-xs lg:text-base font-medium border border-amber-500 rounded-md px-2 dark:text-gray-100"
				>Pro</span
			>
		{/if}
	</div>
</li>
