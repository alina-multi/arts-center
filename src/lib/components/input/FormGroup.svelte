<script lang="ts">
	export let h1: string | boolean = false, h2: string | boolean = false;
	let clazz = '';
	export { clazz as class };
</script>

<div
	class="{clazz} rounded-sm overflow-hidden  bg-white   dark:bg-zinc-800 dark:border-zinc-700 "
>
	{#if h1}
		<h2
			class="text-base font-semibold leading-7 bg-zinc-600 dark:dark:bg-zinc-900 dark:border border-zinc-700  text-white dark:text-white  py-3 px-9 shadow-sm "
		>
			{h1}
		</h2>
	{/if}

	<div class="flex flex-col gap-6 px-6 md:px-9 py-6 border-x border-b   border-zinc-200 dark:border-zinc-700">
		{#if h2}
		<p class="text-sm leading-6 text-zinc-600 dark:text-zinc-300">{h2}</p>
	{/if}
		<slot />
	</div>
</div>
