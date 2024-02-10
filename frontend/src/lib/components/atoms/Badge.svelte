<script lang="ts">
	export let color: 'red' | 'green' | 'blue' | 'orange' | 'gray' = 'gray';
	let style = `bg-${color}-50 text-${color}-700 ring-${color}-600/10`;
</script>

<span
	class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {style}"
>
	<slot />
</span>
