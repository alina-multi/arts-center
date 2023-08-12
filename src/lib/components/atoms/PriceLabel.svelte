<script lang="ts">
	export let price, style: string;
</script>

{#if price}
	<p class="  {style} ml-2 bg-teal-600/60 dark:bg-teal-700/60 rounded-sm text-white">
		${price}
	</p>{/if}
