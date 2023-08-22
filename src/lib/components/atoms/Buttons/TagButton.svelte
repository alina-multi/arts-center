<script lang="ts">
	export let href: string, active: boolean = false, title: string, styles: string = 'px-4 py-2  dark:border-zinc-800 ';
</script>

{#if title}
	<a
		{href}
		class=" border border-gray-200 shadow-sm hover:border-amber-500 hover:shadow-md dark:hover:border-amber-500 rounded-md
            {active ? 'bg-amber-600 dark:bg-amber-600 text-white' : 'dark:bg-zinc-900 bg-white'} {styles}"
		>{title}</a
	>
{/if}
