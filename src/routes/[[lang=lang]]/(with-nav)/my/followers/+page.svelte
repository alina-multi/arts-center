<script lang="ts">
	import { page } from '$app/stores';

	let folllows = $page.data.currentUser?.follows;
	
</script>

<div>
	{#if folllows > 0}
		{#each folllows as folllow}
			<div>{folllow}</div>
		{/each}
	{:else}
		<div>no follows</div>
	{/if}
</div>
