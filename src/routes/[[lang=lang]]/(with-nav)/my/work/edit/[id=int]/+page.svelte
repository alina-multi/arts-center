<script lang="ts">
	import type { PageData, ActionData } from './$types';
	import { enhance } from '$app/forms';
	import WorkForm from '$lib/components/forms/WorkForm.svelte';

	export let data: PageData;
	export let form: ActionData;
</script>

<form method="post" use:enhance>
	<WorkForm {data} errors={form?.errors} />
</form>
