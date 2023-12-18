<script lang='ts'>
	import newUniqueId from 'locally-unique-id-generator';
	import {createEventDispatcher} from'svelte';
	import { browser } from '$app/environment';
	const dispatch = createEventDispatcher();

	export let value = '';
	export let index:number, focus:number;
	function keyDown(event: KeyboardEvent) {
		if (event.key === 'Enter') {
      dispatch('addBlock');
			event.preventDefault();
    }
		if (event.key === 'Backspace' && value === '') {
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
	let inputElement:HTMLElement;

	$: {
		if (focus === index && inputElement) {
			const selection = window.getSelection();
			const range = document.createRange();
			selection?.removeAllRanges();
			range.selectNodeContents(inputElement);
			range.collapse(false);
			selection?.addRange(range);
			inputElement?.focus();
			focus = undefined;
		}
	}
</script>

<div
	bind:this={inputElement}
	class='text-xl outline-0'
	contenteditable
	bind:innerHTML={value}
	on:keydown={keyDown}
/>