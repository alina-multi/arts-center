<script lang="ts">
	export let href: string,
		active: boolean = false,
		title: string,
		styles: string = 'px-4 py-2  dark:border-zinc-800 ';
</script>

{#if title}
	<a
		{href}
		class=" border lg:dark:hover:border-amber-500 font-medium
            {active
			? 'bg-amber-600  text-white border-amber-600'
			: ' border-zinc-900 dark:bg-zinc-900 bg-white hover:border-amber-500 lg:hover:shadow'} {styles}"
		>{title}</a
	>
{/if}
