<script lang="ts">
	import { languageFind, localePath } from '$lib/translations';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { PencilSquare } from '@steeze-ui/heroicons';
	import Picture from '$lib/components/atoms/Picture.svelte';
	export let draft;

	$: title = languageFind(draft.titles)?.title;
	$: href = localePath(`/my/work/draft/${draft.id}`);
</script>

<a {href}>
	<Picture
		photo={draft?.preview}
		alt={title}
		class={'aspect-[4/3] flex object-cover w-full h-full hover:opacity-60 transition ease-in-out duration-150'}
	/>
	<p class="absolute text-sm bottom-0 left-0 right-0 px-3 py-2 text-white bg-gray-900/50">
		{title}
	</p>

	<span class="absolute top-0 right-0 m-3 bg-gray-100/50 p-1 rounded-sm">
		<Icon src={PencilSquare} class="w-6 h-6 text-white" />
	</span>
</a>


