<script lang="ts">
	import { handleImgError } from '$lib/helpers/handleImgError.ts';
	import { languageFind, localePath } from '$lib/translations';
	export let work, href, withDesription: boolean;
	let title: string;
	$: title = languageFind(work.titles)?.title;
	$: href = localePath(`/work/${work.id}`);
</script>

<a {href} class="grid gap-1">
	<div class="bg-zinc-300 aspect-[4/3] w-full rounded-md overflow-hidden">
		{#if work.image}
			<img
				class=" aspect-[4/3] w-full object-cover"
				src={work.image.src}
				srcset={work.image.srcset}
				alt="Work Name: {title}"
				on:error={(event) => handleImgError(event)}
			/>
		{/if}
	</div>
	{#if withDesription}
		<div
			class=" inline-flex items-start justify-between font-medium text-gray-900 dark:text-gray-100"
		>
			<h3 class="text-sm">{title}</h3>
			{#if work.price}
				<p class="ml-2 text-xs bg-green-600 px-2 py-1 rounded-md text-white">
					${work.price}
				</p>{/if}
		</div>
	{/if}
</a>
