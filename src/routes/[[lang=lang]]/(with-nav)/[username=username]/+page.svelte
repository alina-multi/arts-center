<script lang="ts">
	import UserPage from '$lib/components/user/UserPage.svelte';
	import type { PageData } from '../$types';

	export let data: PageData;
</script>
<div class="mt-3">
	<UserPage {...data} />
</div>
