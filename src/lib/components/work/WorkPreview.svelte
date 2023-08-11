<script lang="ts">
	import RatingPreview from '$lib/components/rating/RatingPreview.svelte';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import type { Work } from '$lib/interfaces/Work';
	import CrownIcon from '../atoms/CrownIcon.svelte';

	import ImageWork from '$lib/components/atoms/ImageWork.svelte';

	export let work: Work;
</script>

<li
	class="flex flex-col gap-1 lg:gap-0 overflow-hidden lg:w-80 md:w-[23rem] xl:w-[19rem] 2xl:w-[18rem] {work.subscribed
		? ' '
		: ''} "
>
	<div class="group/item relative">
		<ImageWork {work} withDesription />
		<div class="hidden sm:block">
			<div
				class="group/edit hidden group-hover/item:block absolute top-3 right-3 text-white bg-black/50 pt-1 px-1 transition-all rounded-md"
			>
				<RatingPreview rating={work.rating} comments={work.comments} />
			</div>
		</div>
	</div>

	<div class="flex justify-between items-center lg:text-xs text-sm mt-auto">
		<div class="flex items-center gap-1">
			{#each work.owners as user}
				<Avatar {user} withName={true} />
			{/each}

			{#if work.subscribed}
				<div class="bg-gray-300 px-1 py-0.5 rounded-md shadow-sm">
					<CrownIcon style="w-3 h-3 stroke-white" />
				</div>
			{/if}
		</div>

		<div class="flex sm:hidden text-gray-500">
			<RatingPreview rating={work.rating} comments={work.comments} />
		</div>
	</div>
</li>
