<script lang="ts">
	export let h1, h2;
</script>

<div class="pb-3">
	{#if h1}
		<h2 class="text-base font-semibold leading-7 text-gray-900">{h1}</h2>
	{/if}
	{#if h2}
		<p class="mt-1 text-sm leading-6 text-gray-600">{h2}</p>
	{/if}
	<div class="flex flex-col mt-10 space-y-3">
		<slot />
	</div>
</div>
