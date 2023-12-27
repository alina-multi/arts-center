<script lang='ts'>
	import Picture from '$lib/components/atoms/Picture.svelte';
	import { createEventDispatcher } from 'svelte';
	const dispatch = createEventDispatcher();
	export let image, focus, index;
	$: isFocused = index === focus;

	function onKeydown(event: KeyboardEvent) {
		if (event.key === 'Backspace') {
			dispatch('removeBlock');
			event.preventDefault();
    }
	}
</script>

{#if image}
	<div on:keydown={onKeydown} on:focusin={()=>focus=index} tabindex={index + 2}>
		<Picture class='w-full' photo={image} />
	</div>
{/if}