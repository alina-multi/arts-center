<script lang="ts">
	import UserPreviewRegular from '$lib/components/user/UserPreviewRegular.svelte';
	import UserPreviewPremium from '$lib/components/user/UserPreviewPremium.svelte';
	import type { UserPrview } from '$lib/interfaces/User.ts';

	export let users: UserPrview[];
</script>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3  gap-3 mt-3 p-3 ">
	{#each users as user (user.id)}
		{#if user.subscribed}
			<UserPreviewPremium {...user} />
		{:else}
			<div
				class=" flex flex-col border border-gray-200 dark:border-gray-700 gap-3 p-3 rounded-md shadow-sm"
			>
				<UserPreviewRegular {...user} />
			</div>
		{/if}
	{/each}
</div>
