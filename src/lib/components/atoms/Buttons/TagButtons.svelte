<script lang="ts">
	import TagButton from '$lib/components/atoms/Buttons/TagButton.svelte';
	import type { Tag } from '$lib/interfaces/Tag';

	export let tags: Tag[],
		active = () => false,
		params: {
			tag?: string;
			order?: string;
		},
		urlGenerator;
</script>

{#each tags as tag}
	<TagButton
		title={tag?.title}
		href={urlGenerator('tags', tag?.title, params)}
		active={active(tag?.title)}
	/>
{/each}
