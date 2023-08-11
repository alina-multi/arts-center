<script lang="ts">
	import ActionButton from './ActionButton.svelte';

	export let open = false;
</script>

<ActionButton
	type="button"
	class={'bg-gray-500 hover:bg-gray-600 focus-visible:outline-gray-600'}
	on:click={() => {
		open = false;
	}}
>
	<span>Cancel</span>
</ActionButton>
