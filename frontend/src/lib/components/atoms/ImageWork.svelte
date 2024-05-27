<script lang="ts">
	import { languageFind, localePath } from '$lib/translations';
	import Picture from '$lib/components/atoms/Picture.svelte';
	import RatingPreview from '$lib/components/rating/RatingPreview.svelte';
	import PriceLabel from './PriceLabel.svelte';
	import { getContext } from 'svelte';

	export let work,
		withDesription: boolean = false,
		loading;

	const locale = getContext('locale');

	let title = languageFind(work.titles, $locale)?.title;
	let href = localePath($locale, `/work/${work.id}`);
</script>

<a {href} class="grid gap-1">
	<div class="rounded-sm bg-gray-200 dark:bg-zinc-900 overflow-hidden aspect-[4/3]">
		{#if work.preview}
			<Picture
				photo={work.preview}
				alt={title}
				class={'aspect-[4/3] flex object-cover w-full h-full'}
				{loading}
			/>
		{/if}
	</div>
	{#if withDesription}
		<div class=" inline-flex items-center justify-between text-black dark:text-gray-100">
			<div class="flex items-center sm:justify-between w-full font-medium">
				<h3 class="text-sm line-clamp-1">{title}</h3>
				<PriceLabel price={work.price} style={'py-0.5 text-sm md:text-xs  px-2'} />
			</div>

			<div>
				<RatingPreview rating={work.rating} comments={work.comments} />
			</div>
		</div>
	{/if}
</a>
