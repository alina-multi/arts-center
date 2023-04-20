<script lang="ts">
	import UserPreviewRegular from '$lib/components/user/UserPreviewRegular.svelte';
	import UserPreviewPremium from '$lib/components/user/UserPreviewPremium.svelte';
	import LastWorks from '$lib/components/atoms/LastWorks.svelte';
	import type { UserPrview } from '$lib/interfaces/User.ts';
	import UsersFilters from '$lib/components/user/UsersFilters.svelte';

	export let users: UserPrview[], categories, countries, params;
</script>

<div class="flex flex-col xl:flex-row max-xl:gap-3 mt-3">
	<div class="xl:w-3/12 border  p-3 sm:px-6 sm:py-3 rounded-md ">
		<UsersFilters tags={categories} {countries} {params} />
	</div>
	<div class="flex flex-col gap-3 xl:pl-3  xl:w-9/12">
		{#each users as user (user.id)}
			{#if user.subscribed}
				<UserPreviewPremium {user} />
			{:else}
				<div
					class="flex flex-col items-center sm:flex-row max-sm:gap-1 md:gap-3 shadow-sm border rounded-md w-full dark:border-gray-700 "
				>
					<div
						class=" flex items-center  grow w-full sm:w-1/2 text-lg px-3 pt-3 sm:pb-3  gap-3 overflow-hidden"
					>
						<UserPreviewRegular {user} />
					</div>
					<div
						class="px-3 pb-3 sm:p-3 lg:p-0 flex justify-end sm:w-1/2    dark:border-gray-700 gap-3   overflow-hidden "
					>
						<LastWorks works={user.works} />
					</div>
				</div>
			{/if}
		{/each}
	</div>
</div>
