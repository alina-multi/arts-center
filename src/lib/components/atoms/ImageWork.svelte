<script lang="ts">
	import { handleImgError } from '$lib/helpers/handleImgError.ts';
	import { languageFind, localePath } from '$lib/translations';
	import Picture from '$lib/components/atoms/Picture.svelte';
	export let work, href, withDesription: boolean = false;
	let title: string;

	$: title = languageFind(work.titles)?.title;

	
	$: href = localePath(`/work/${work.id}`);

</script>


<a {href} class="grid gap-1">
	
	<div class="rounded-sm bg-gray-100 dark:bg-zinc-900 overflow-hidden aspect-[4/3]">
		{#if work.preview}
	<div class="">
		<Picture photo={work.preview} alt={title} style={"aspect-[4/3] flex object-cover"} />
	</div>
		{/if}
		
	</div>
	{#if withDesription}
		<div
			class=" inline-flex items-start justify-between font-medium text-gray-900 dark:text-gray-100"
		>
			<h3 class="lg:text-sm">{title}</h3>
			{#if work.price}
				<p class="ml-2 text-xs bg-green-600 px-2 py-1 rounded-md text-white">
					${work.price}
				</p>{/if}
		</div>
	{/if}
</a>

