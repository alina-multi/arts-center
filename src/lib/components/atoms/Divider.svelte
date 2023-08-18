<script>
	export let styles = 'px-2 text-sm';
</script>

<div class="relative my-3">
	<div class="absolute inset-0 flex items-center" aria-hidden="true">
		<div class="w-full border-t border-gray-300 dark:border-zinc-700" />
	</div>
	<div class="relative flex justify-center">
		<span class=" {styles} bg-white dark:bg-zinc-900 text-gray-500 dark:text-white">
			<slot />
		</span>
	</div>
</div>
