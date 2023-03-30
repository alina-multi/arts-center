<script lang="ts">
	import RatingPreview from '$lib/components/rating/RatingPreview.svelte';
	import UserPreviewInline from '$lib/components/user/UserPreviewInline.svelte';
	import type { Work } from '$lib/interfaces/Work';
	import { languageFind, localePath } from '$lib/translations';
	import { handleImgError } from '$lib/helpers/handleImgError.ts';

	export let work: Work;
	let title: string;
	$: title = languageFind(work.titles)?.title;
	$: href = localePath(`/work/${work.id}`);
</script>

<!-- onerror="this.onerror=null;this.srcset='{image_not_found}'; this.src='{image_not_found}'; this.style='object-fit: contain; object-position: center;';" //////    works, but sometimes only on the first load of the page, and sometimes not at all -->
<li
	class="flex flex-col gap-1 rounded-md overflow-hidden lg:w-80 md:w-[23rem] xl:w-[19rem] 2xl:w-[18rem] {work.subscribed
		? ' '
		: ''} "
>
	<div class="group/item relative">
		<a {href} class="grid gap-2">
			<div class="bg-zinc-300  aspect-[4/3] w-full rounded-md">
				{#if work.image}
					<img
						class="rounded-md  aspect-[4/3] w-full object-cover "
						src={work.image.src}
						srcset={work.image.srcset}
						alt="Work Name: {title}"
						on:error={(event) => handleImgError(event)}
					/>
				{/if}
			</div>
			<div
				class=" inline-flex items-start justify-between font-medium text-gray-900 dark:text-gray-100"
			>
				<h3 class="text-md">{title}</h3>
				{#if work.price}
					<p class="ml-2 lg:text-sm bg-green-600 px-2 py-1 rounded-md text-white">
						${work.price}
					</p>{/if}
			</div>
		</a>
		<div
			class="group/edit invisible group-hover/item:visible absolute top-3 right-3 text-white bg-black/50 pt-1 px-1 rounded-md transition-all"
		>
			<RatingPreview rating={work.rating} comments={work.comments} />
		</div>
	</div>

	<div class="flex justify-between items-center text-sm text-gray-500 mt-auto">
		{#each work.owners as user}
			<div class="mr-3"><UserPreviewInline {user} /></div>
		{/each}

		{#if work.subscribed}
			<span
				class="mr-2 shadow-md text-lg lg:text-base font-medium border border-amber-500 rounded-md px-2 dark:text-gray-100"
				>Pro</span
			>
		{/if}
	</div>
</li>
