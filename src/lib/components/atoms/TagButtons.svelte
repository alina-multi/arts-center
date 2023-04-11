<script lang="ts">
	import TagButton from '$lib/components/atoms/TagButton.svelte';
	import type { Tag } from '$lib/interfaces/Tag';

	export let tags: Tag[],
		active = (tag: string) => false,
		clickHandler = (tag: string) => {
			/**/
		},
		href: string,
		dots: boolean;
</script>

{#each tags as tag}
	<TagButton
		title={tag?.title}
		clickHandler={() => clickHandler(tag?.title)}
		active={active(tag?.title)}
		{href}
		{dots}
	/>
{/each}
