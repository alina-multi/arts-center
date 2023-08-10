<script lang="ts">
	import ActionButton from '$lib/components/forms/ActionButton.svelte';
</script>

<div class="flex itmes-center justify-end gap-3">
	<slot><ActionButton class={"bg-blue-600 hover:bg-blue-500 focus-visible:outline-blue-600"}  /></slot>
</div>