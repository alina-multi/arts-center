<script lang="ts">
	import type { ActionData } from './$types';
	import AuthPage from '$lib/components/auth/AuthPage.svelte';

	export let form: ActionData;
</script>

<AuthPage {form} />
