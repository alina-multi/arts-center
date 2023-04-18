<script lang="ts">
	import TagButton from '$lib/components/atoms/TagButton.svelte';
	import type { Tag } from '$lib/interfaces/Tag';

	export let tags: Tag[],
		active = (tag: string) => false,
		params: {
			tag?: string;
			order?: string;
		},
		urlGenerator;
</script>

{#each tags as { title }}
	<TagButton {title} href={urlGenerator('tags', title, params)} active={active(title)} />
{/each}
