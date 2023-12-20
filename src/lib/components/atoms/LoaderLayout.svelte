<script lang="ts">
	import Loader from '$lib/components/atoms/Loader.svelte';
</script>

<div
	class="fixed inset-0 backdrop-blur-sm bg-white/30 dark:bg-black/30 flex justify-center items-center z-[1005]"
>
	<div class="h-1/2 w-1/2 opacity-50">
		<Loader />
	</div>
</div>
