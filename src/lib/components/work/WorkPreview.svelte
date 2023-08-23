<script lang="ts">
	import RatingPreview from '$lib/components/rating/RatingPreview.svelte';
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import type { Work } from '$lib/interfaces/Work';
	import CrownIcon from '../atoms/CrownIcon.svelte';

	import ImageWork from '$lib/components/atoms/ImageWork.svelte';

	export let work: Work;
</script>

<li
	class="flex flex-col gap-1 lg:gap-0 overflow-hidden {work.subscribed
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
				<AvatarLink {user} withName={true} />
			{/each}

			{#if work.subscribed}
				<div class="bg-gray-300 dark:bg-zinc-700 px-1 py-0.5 rounded-sm shadow-sm">
					<CrownIcon style="w-3 h-3 stroke-white dark:stroke-zinc-300" />
				</div>
			{/if}
		</div>
	</div>
</li>
