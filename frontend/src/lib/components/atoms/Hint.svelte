<script lang="ts">
	import { QuestionMarkCircle, ExclamationTriangle, ExclamationCircle } from '@steeze-ui/heroicons';
	import { Icon } from '@steeze-ui/svelte-icon';

	export let type: 'info' | 'warning' | 'danger';
	let icon;
	let colours;

	if (type === 'info') {
		icon = QuestionMarkCircle;
		colours = 'text-zink-300';
	}

	if (type === 'warning') {
		icon = ExclamationTriangle;
		colours = 'text-orange-300';
	}

	if (type === 'danger') {
		icon = ExclamationCircle;
		colours = 'text-red-300';
	}
</script>

<div
	class="rounded-sm overflow-hidden border bg-white shadow-sm dark:bg-zinc-800 dark:border-zinc-700 p-3 {colours}"
>
	<Icon class="w-4 h-4 inline-block mr-1" src={icon} /><slot />
</div>
