<script lang="ts">
	import Badge from '$lib/components/atoms/Badge.svelte';
	import { getContext } from 'svelte';

	const t = getContext('t');
	export let status;
	let color, statusGroup;
	if (status == 0) {
		statusGroup = 'error';
		color = 'red';
	} else if (status <= 5) {
		statusGroup = 'draft';
		color = 'gray';
	} else if (status <= 10) {
		statusGroup = 'waiting';
		color = 'blue';
	} else if (status <= 30) {
		statusGroup = 'processing';
		color = 'blue';
	} else if (status >= 40) {
		statusGroup = 'published';
		color = 'green';
	}
</script>

<Badge {color}>
	{$t(`my.works_page.statuses.${statusGroup}`)}
</Badge>
