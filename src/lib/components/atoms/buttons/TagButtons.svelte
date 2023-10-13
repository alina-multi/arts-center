<script lang="ts">
	import TagButton from '$lib/components/atoms/buttons/TagButton.svelte';
	import type { Tag } from '$lib/interfaces/Tag';
	import { slug } from '$lib/helpers/url.js';

	export let tags: Tag[],
		active = () => false,
		params: {
			tag?: string;
			order?: string;
		},
		selected,

		urlGenerator;
</script>

{#each tags as tag (tag?.title)}
	<TagButton
		title={tag?.title}
		href={urlGenerator('tags', slug(tag?.title), params, selected)}
		active={active(tag?.title)}
	/>
{/each}
