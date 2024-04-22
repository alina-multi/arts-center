<script lang="ts">
	export let text: string;
	import { getContext } from 'svelte';
	const t = getContext('t');
</script>

<h1 class="text-center font-medium text-xl tracking-widest">
	{$t(text)}
</h1>
