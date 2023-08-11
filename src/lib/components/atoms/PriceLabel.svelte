<script cang="ts">
export let price;
</script>

{#if price}
				<p class="ml-2 py-0.5  text-sm md:text-xs bg-teal-600/60 dark:bg-teal-700/60 px-2 rounded-sm text-white">
					${price}
				</p>{/if}