<script lang="ts">
	export let type: 'button' | 'submit' | 'reset' = 'button';
	let clazz = '';
	export { clazz as class };
</script>

<button {type} on:click class="{clazz} inline-flex items-center justify-center">
	<slot />
</button>
