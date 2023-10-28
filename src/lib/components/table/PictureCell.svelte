<script lang="ts">
	import type { Picture as PictureType } from '$lib/interfaces/Picture';
	import Picture from '$lib/components/atoms/Picture.svelte';

	export let preview: PictureType
</script>

{#if preview?.src}
	<Picture photo={preview} class='xs:aspect-[4/3] w-32 object-cover'/>
{/if}