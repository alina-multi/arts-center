<script lang="ts">
	import Picture from '$lib/components/atoms/Picture.svelte';
	import { createEventDispatcher } from 'svelte';
	const dispatch = createEventDispatcher();
	export let image, focus, index;

	function onKeydown(event: KeyboardEvent) {
		if (event.key === 'Backspace') {
			dispatch('removeBlock');
			event.preventDefault();
		}
		if (event.key === 'ArrowUp') {
			dispatch('moveUp');
			event.preventDefault();
		}
		if (event.key === 'ArrowDown') {
			dispatch('moveDown');
			event.preventDefault();
		}
		if (event.key === 'Enter') {
			dispatch('addBlock');
			event.preventDefault();
		}
	}
</script>

{#if image}
	<!-- svelte-ignore a11y-no-noninteractive-tabindex -->
	<!-- svelte-ignore a11y-no-static-element-interactions -->
	<div on:keydown={onKeydown} on:focusin={() => (focus = index)} tabindex={index + 2}>
		<Picture class="w-full" photo={image} />
	</div>
{/if}
