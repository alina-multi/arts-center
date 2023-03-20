<script lang="ts">
	import TagButton from "$lib/components/atoms/TagButton.svelte";
	import type { Tag } from "../../interfaces/Tag";

	export let tags: Tag[];
</script>

{#each tags as tag}
	<TagButton {tag} />
{/each}
