<script lang="ts">
	import UserPreviewList from '$lib/components/user/UserPreviewList.svelte';
	import type { PageData } from './$types';

	export let data: PageData;
</script>

<UserPreviewList {...data} />
