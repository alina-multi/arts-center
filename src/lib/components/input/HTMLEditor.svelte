<script lang="ts">
	import { browser } from '$app/environment';
	import { createEventDispatcher, onMount, tick } from 'svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import {
		FormatBold,
		FormatItalic,
		Link,
		FormatClear,
		CheckCircle,
		Cancel
	} from '@steeze-ui/material-design-icons';

	const dispatch = createEventDispatcher();
	export let value: string, tabindex: number, focus: number, inputElement: HTMLElement;

	let clazz: string,
		linkInput: HTMLElement,
		lastSelection,
		menu: 'hidden' | 'menu' | 'link' = 'hidden',
		editable,
		url: string;

	export { clazz as class };
	onMount(async () => {
		if (browser) {
			const { Editable } = await import('@livingdocs/editable.js');
			editable = new Editable({ defaultBehavior: false });
			editable.enable(inputElement, { normalize: true });
			editable
				.selection((element, selection) => {
					if (element === inputElement) {
						if (selection?.isSelection) {
							lastSelection = selection;
							menu = 'menu';
						}
					}
				})
				.blur((element) => {
					if (element === inputElement) {
						if (menu === 'menu') {
							menu = 'hidden';
						}
					}
				})
				.on('switch', (element, direction) => {
					if (element === inputElement) {
						direction === 'up' ? dispatch('moveUp') : dispatch('moveDown');
					}
				})
				.on('merge', (element) => {
					if (element === inputElement) {
						dispatch('removeBlock');
					}
				})
				.on('split', (element) => {
					if (element === inputElement) {
						dispatch('addBlock');
					}
				})
				.on('insert', (element) => {
					if (element === inputElement) {
						dispatch('addBlock');
					}
				});
		}
	});

	$: if (focus === tabindex) {
		focusAtTheEnd(inputElement);
	}

	function focusAtTheEnd(element: HTMLElement) {
		if (element) {
			const selection = window.getSelection();
			const range = document.createRange();
			selection?.removeAllRanges();
			range.selectNodeContents(element);
			range.collapse(false);
			selection?.addRange(range);
			element?.focus();
		}
	}
	async function openLinkInput() {
		menu = 'link';
		url = '';
		await tick();
		linkInput?.focus();
	}

	function confirmLink() {
		lastSelection.toggleLink(url);
		menu = 'hidden';
		forceChange();
	}

	function emphasis() {
		lastSelection.toggleEmphasis();
		forceChange();
	}

	function bold() {
		lastSelection.toggleBold();
		forceChange();
	}

	function clear() {
		lastSelection.removeFormatting();
		forceChange();
	}

	// Because editable.js intercepts events svelte is not able to update when you click buttons
	function forceChange() {
		value = inputElement.innerHTML;
	}
</script>

<div class="relative">
	{#if menu === 'link'}
		<div
			class="absolute flex left-0 -top-5 bg-zinc-700 dark:bg-zinc-900 dark:border border-zinc-700 text-white dark:text-white"
		>
			<input
				class="bg-zinc-700 dark:bg-zinc-900 dark:border border-zinc-700 text-white dark:text-white"
				bind:this={linkInput}
				bind:value={url}
				type="url"
				placeholder=""
			/>
			<button on:click={confirmLink}>
				<Icon src={CheckCircle} class="w-6 h-6" />
			</button>
			<button on:click={() => (menu = 'hidden')}>
				<Icon src={Cancel} class="w-6 h-6" />
			</button>
		</div>
	{/if}
	{#if menu === 'menu'}
		<div
			tabindex="0"
			role="menu"
			on:mousedown|preventDefault={() => {}}
			class="absolute left-0 -top-5 bg-zinc-700 dark:bg-zinc-900 dark:border border-zinc-700 text-white dark:text-white"
		>
			<button on:click={bold}>
				<Icon src={FormatBold} class="w-5 h-5" />
			</button>
			<button on:click={emphasis}>
				<Icon src={FormatItalic} class="w-5 h-5" />
			</button>
			<button on:click={openLinkInput}>
				<Icon src={Link} class="w-5 h-5" />
			</button>
			<button on:click={clear}>
				<Icon src={FormatClear} class="w-5 h-5" />
			</button>
		</div>
	{/if}
	<!-- svelte-ignore a11y-no-noninteractive-tabindex -->
	<div
		bind:this={inputElement}
		class={clazz + ' contenteditable'}
		contenteditable
		bind:innerHTML={value}
		on:focusin={() => (focus = tabindex)}
		{tabindex}
	/>
</div>
{value}

<style>
	:global(.contenteditable a) {
		color: blue;
		text-decoration: underline !important;
	}
	:global(.contenteditable a:hover) {
		color: lightblue;
	}
</style>
