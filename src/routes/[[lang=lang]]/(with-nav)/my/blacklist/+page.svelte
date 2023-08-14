<script lang="ts">
	import { page } from '$app/stores';
	import BlockButton from '$lib/components/atoms/BlockButton.svelte';
	let blacklists = $page.data.currentUser?.blacklists;
</script>

{#if blacklists?.length > 0}
	<h1>Blacklist</h1>

	{#each blacklists as user}
		<div>
			{user}
			<BlockButton user={{ id: user }} type="unblock" />
		</div>
	{/each}
{:else}
	<h1>Blacklist</h1>
	<p>There are no users in your blacklist</p>
{/if}
