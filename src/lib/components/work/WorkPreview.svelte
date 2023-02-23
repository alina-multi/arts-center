<script lang="ts">
	import RatingPreview from '$lib/components/rating/RatingPreview.svelte';
	import UserPreviewInline from '$lib/components/user/UserPreviewInline.svelte';
	import type { Work } from '../../interfaces/Work';
    import image_not_found from '$lib/image_not_found.svg';
    import { browser } from "$app/environment";
	export let work: Work;
	let title: string;
	$: title = work.titles[0].title; // For now, later use language
  
    export const handleImgError = (event) => {
        console.log( event);
     if (browser) {
        event.target.onerror = null;
        event.target.srcset = image_not_found;
        event.target.src = image_not_found;
        event.target.style = 'object-fit: contain; object-position: center;';
    }
}

</script>

<!-- onerror="this.onerror=null;this.srcset='{image_not_found}'; this.src='{image_not_found}'; this.style='object-fit: contain; object-position: center;';" //////    works, but sometimes only on the first load of the page, and sometimes not at all --> 

<li
	class="flex flex-col gap-2 rounded-md overflow-hidden lg:w-80 xl:w-[19rem]  md:w-[23rem] {work.subscribed
		? ' '
		: ''} "
>
	<div class="group/item relative">
		<a href="/work/{work.id}" class="grid gap-2">
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
				class=" inline-flex items-start justify-between font-medium text-gray-900 dark:text-zinc-100"
			>
				<h3 class=" text-lg lg:text-sm">{title}</h3>
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

	<div class="flex justify-between items-center text-base font-medium lg:text-sm mt-auto">
		{#each work.owners as user}
			<UserPreviewInline {user} />
		{/each}

		{#if work.subscribed}
			<span
				class="mr-2 shadow-md text-lg lg:text-base font-medium border border-amber-500 rounded-md px-2 dark:text-zinc-100"
				>Pro</span
			>
		{/if}
	</div>
</li>
