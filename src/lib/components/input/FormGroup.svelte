<script lang="ts">
	export let h1: string | boolean = false, h2: string | boolean = false;
	let clazz = '';
	export { clazz as class };
</script>

<div
	class="{clazz} rounded-sm overflow-hidden border bg-white shadow-sm dark:bg-zinc-800 dark:border-zinc-700"
>
	{#if h1}
		<h2
			class="text-base font-semibold leading-7 text-gray-900 dark:text-white border-b py-3 px-3 lg:px-16 shadow-sm dark:border-b-zinc-700"
		>
			{h1}
		</h2>
	{/if}
	{#if h2}
		<p class="px-3 lg:px-16 mt-1 text-sm leading-6 text-gray-600 dark:text-zinc-400">{h2}</p>
	{/if}
	<div class="flex flex-col gap-3 px-3 lg:px-16 py-6">
		<slot />
	</div>
</div>
