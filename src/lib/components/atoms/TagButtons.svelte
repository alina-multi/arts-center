<script lang="ts">
	import TagButton from '$lib/components/atoms/buttons/TagButton.svelte';
	import type { Tag } from '$lib/interfaces/Tag';

	export let tags: Tag[],
		active = (tag: string) => false,
		clickHandler = (tag: string) => {
			/**/
		},
		href: string,
		dots: boolean;
</script>

{#each tags as { title }}
	<TagButton
		{title}
		clickHandler={() => clickHandler(title)}
		active={active(title)}
		{href}
		{dots}
	/>
{/each}
