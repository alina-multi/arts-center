<script>
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Flag } from '@steeze-ui/heroicons';
</script>

<button
	type="button"
	class="flex items-center gap-3 px-6 py-2 hover:bg-gray-100 dark:hover:text-gray-200 dark:hover:bg-gray-600 font-semibold"
>
	<Icon src={Flag} theme="solid" class="h-5 w-5 " aria-hidden="true" />
	<span class="sr-only">Report</span>
	<span>Report</span>
</button>
