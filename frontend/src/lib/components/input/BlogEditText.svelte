<script lang="ts">
	import HTMLEditor from '$lib/components/input/HTMLEditor.svelte';
	import { browser } from '$app/environment';

	export let value = '';
	export let tabindex: number, focus: number;
</script>

{#if browser}
	<HTMLEditor
		class="sm:text-xl outline-0 font-serif leading-7 md:leading-8"
		{tabindex}
		bind:focus
		bind:value
		on:removeBlock
		on:addBlock
		on:moveUp
		on:moveDown
	/>
{/if}
