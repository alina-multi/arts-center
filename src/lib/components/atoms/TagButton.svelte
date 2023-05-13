<script lang="ts">
	export let href: string, active: boolean, title: string;
</script>

{#if title}
	<a
		{href}
		class="border border-gray-200 dark:border-gray-800 px-4 py-2 shadow-sm hover:border-amber-500 hover:shadow-md dark:hover:border-amber-500 rounded-md
            {active ? 'bg-amber-600 dark:bg-amber-600 text-white' : 'dark:bg-gray-900'}">{title}</a
	>
{/if}
