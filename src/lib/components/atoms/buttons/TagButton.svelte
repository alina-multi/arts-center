<script lang="ts">
	export let href: string, active: boolean, clickHandler: () => void, title: string;
</script>

<a
	{href}
	on:click={clickHandler}
	class="border border-gray-200 dark:border-gray-400 px-4 py-2 hover:border-amber-500hover:shadow-sm  dark:hover:border-amber-500 rounded-md
            {active ? 'bg-amber-600 text-white' : ''}">{title}</a
>
