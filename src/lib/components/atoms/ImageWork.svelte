<script lang="ts">
	import { languageFind, localePath } from '$lib/translations';
	import Picture from '$lib/components/atoms/Picture.svelte';
	import RatingPreview from '$lib/components/rating/RatingPreview.svelte';
	import PriceLabel from './PriceLabel.svelte';

	export let work,
		href,
		withDesription = false;
	let title: string;

	$: title = languageFind(work.titles)?.title;

	$: href = localePath(`/work/${work.id}`);
</script>

<a {href} class="grid gap-1">
	<div class="rounded-sm bg-gray-200 dark:bg-zinc-900 overflow-hidden aspect-[4/3]">
		{#if work.preview}
			<Picture
				photo={work.preview}
				alt={title}
				style={'aspect-[4/3] flex object-cover w-full h-full'}
			/>
		{/if}
	</div>
	{#if withDesription}
		<div
			class=" inline-flex items-center justify-between font-medium text-gray-900 dark:text-gray-100"
		>
			<div class="flex items-center sm:justify-between w-full">
				<h3 class="lg:text-sm">{title}</h3>
				<PriceLabel price={work.price} style={'py-0.5 text-sm md:text-xs  px-2'} />
			</div>

			<div class="flex sm:hidden text-gray-500">
				<RatingPreview rating={work.rating} comments={work.comments} />
			</div>
		</div>
	{/if}
</a>
