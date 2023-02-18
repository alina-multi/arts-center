<script lang="ts">
	import WorkItem from './WorkItem.svelte';
	import UserPreviewInline from '$lib/components/user/UserPreviewInline.svelte';
	import RatingPreview from '$lib/components/rating/RatingPreview.svelte';
	export let works;
</script>

<ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
	{#each works as work (work.id)}
		<li class="flex flex-col gap-2 rounded-md {work.subscribed ? ' ' : ''} ">
			<div class="group/item relative">
				<WorkItem title={work.title} src={work.image.url} price={work.price} />
				<div
					class="group/edit invisible group-hover/item:visible absolute top-3 right-3 text-white bg-black/50 pt-1 px-1 rounded-md transition-all"
				>
					<RatingPreview rating={work.rating} comments={work.comments} />
				</div>
			</div>

			<div class="flex justify-between items-center text-base font-medium lg:text-sm mt-auto">
				<UserPreviewInline name={work.author} src={work.userPhoto} price={work.price} />
				{#if work.subscribed}
					<span
						class="mr-2 shadow-md text-lg lg:text-base font-medium border border-amber-500 rounded-md px-2 dark:text-zinc-100 "
						>Pro</span
					>
				{/if}
			</div>
		</li>

	{/each}
</ul>

