<script lang="ts">
	import ActionButton from './ActionButton.svelte';
	import { getContext } from 'svelte';

	const t = getContext('t');

	export let open = false;
</script>

<ActionButton
	type="button"
	class={'bg-zinc-400 dark:bg-zinc-700 hover:bg-zinc-500 focus-visible:outline-zinc-600'}
	on:click={() => {
		open = false;
	}}
>
	<span>{$t('global.buttons.cancel')}</span>
</ActionButton>
