<script lang="ts">
	import type { Picture as PictureType } from '$lib/interfaces/Picture';
	import Picture from '$lib/components/atoms/Picture.svelte';

	export let preview: PictureType
</script>

{#if preview?.src}
	<Picture photo={preview} class='w-20 h-20'/>
{/if}