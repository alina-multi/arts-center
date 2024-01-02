<script lang="ts">
	import { createEventDispatcher } from 'svelte';
	const dispatch = createEventDispatcher();

	export let value = '';
	export let index: number, focus: number;
	function keyDown(event: KeyboardEvent) {
		if (event.key === 'Enter') {
			dispatch('addBlock');
			event.preventDefault();
		}
		// When you delete everything, browser adds <br>
		if (event.key === 'Backspace' && ['<br>', ''].includes(value)) {
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
	}
	let inputElement: HTMLElement;

	$: {
		if (focus === index && inputElement) {
			const selection = window.getSelection();
			const range = document.createRange();
			selection?.removeAllRanges();
			range.selectNodeContents(inputElement);
			range.collapse(false);
			selection?.addRange(range);
			inputElement?.focus();
		}
	}
</script>

<!-- svelte-ignore a11y-no-noninteractive-tabindex -->
<!-- svelte-ignore a11y-no-static-element-interactions -->
<div
	bind:this={inputElement}
	class="sm:text-xl outline-0 font-serif leading-7 md:leading-8"
	contenteditable
	bind:innerHTML={value}
	on:keydown={keyDown}
	on:focusin={() => (focus = index)}
	tabindex={index + 2}
/>
