<script lang="ts">
	import UserPreviewRegular from '$lib/components/user/UserPreviewRegular.svelte';
	import UserPreviewPremium from '$lib/components/user/UserPreviewPremium.svelte';
	import LastWorks from '$lib/components/atoms/LastWorks.svelte';
	import type { UserPrview } from '$lib/interfaces/User.ts';

	export let users: UserPrview[];
</script>

<div class="flex  mt-3">
	<div class="w-3/12 border  p-3 rounded-md">FILTERS</div>
	<div class="flex flex-col gap-3 pl-3  w-9/12">
		{#each users as user (user.id)}
			{#if user.subscribed}
				<UserPreviewPremium {...user} />
			{:else}
				<div class="flex shadow-sm ">
					<div
						class=" -mr-1 items-center w-1/2 text-lg p-3 flex  border border-gray-200 dark:border-gray-700 gap-3 border-r-transparent rounded-l-md overflow-hidden"
					>
						<UserPreviewRegular {...user} />
					</div>
					<div
						class="flex justify-end w-1/2  border border-gray-200 dark:border-gray-700 gap-3 border-l-transparent rounded-r-md overflow-hidden "
					>
						<LastWorks works={user.works} />
					</div>
				</div>
			{/if}
		{/each}
	</div>
</div>
