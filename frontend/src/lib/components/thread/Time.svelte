<script lang="ts">
	import { getContext } from 'svelte';

	export let date: Date;
	const locale = getContext('locale');

	let localeTime = new Date(date).toLocaleTimeString($locale, {
		year: '2-digit',
		month: 'short',
		day: '2-digit',
		hour: '2-digit',
		minute: '2-digit'
	});
</script>

{localeTime}
