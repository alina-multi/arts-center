<script lang="ts">
	import ActionButton from './ActionButton.svelte';
	import { getContext } from 'svelte';

	const t = getContext('t');

	export let open = false;
</script>

<ActionButton
	type="button"
	class={'bg-zinc-500 hover:bg-zinc-600 focus-visible:outline-gray-600'}
	on:click={() => {
		open = false;
	}}
>
	<span>{$t('global.buttons.cancel')}</span>
</ActionButton>
