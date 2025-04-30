<script lang="ts">
	import BlockedUsersPage from '$lib/components/my/BlockedUsersPage.svelte';

	export let data;
</script>

<BlockedUsersPage blacklist={data.blacklist} />
