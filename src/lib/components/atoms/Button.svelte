<script lang="ts">
	import { createEventDispatcher } from 'svelte';

	export let type: 'button' | 'submit' | 'reset' = 'button',
		customClass = '';
	const dispatch = createEventDispatcher();
	let open = false;

	function handleClick() {
		dispatch('open'), dispatch('close');
	}
</script>

<button {type} on:click={handleClick} class="{customClass} inline-flex items-center justify-center">
	<slot />
</button>
