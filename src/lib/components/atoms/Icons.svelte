<script lanf="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ArrowLongLeft } from '@steeze-ui/heroicons';
	export let type;
</script>

{#if type === 'arrowBack'}
	<a href="/" class="rounded-md hover:bg-gray-100 dark:stroke-gray-100 dark:hover:bg-gray-700">
		<Icon src={ArrowLongLeft} class=" w-8 h-8 stroke-gray-900 dark:stroke-gray-100  " />
	</a>
{/if}
