<script lang="ts">
	import { getContext } from 'svelte';

	export let date: Date;
	const locale = getContext('locale');

	let localeDate = new Date(date).toLocaleDateString($locale, {
		year: '2-digit',
		month: 'short',
		day: '2-digit'
	});
</script>

{localeDate}
