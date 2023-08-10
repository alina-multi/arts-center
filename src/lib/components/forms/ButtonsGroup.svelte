<script lang="ts">
	import FormButton from '$lib/components/forms/FormButton.svelte';
</script>

<div class="flex itmes-center justify-end gap-3">
	<slot><FormButton class={"bg-blue-600 hover:bg-blue-500 focus-visible:outline-blue-600"}  /></slot>
</div>