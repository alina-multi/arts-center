<script lang="ts">
	import UserPreview from '$lib/components/user/UserPreview.svelte';
	import HeaderLayout from '$lib/components/my/HeaderLayout.svelte';
	import FollowButton from '$lib/components/atoms/buttons/FollowButton.svelte';
	import { t } from '$lib/translations';

	export let data;
	let users = data.users;
</script>

<div>
	<HeaderLayout title={$t('my.follow.following')}>
		<span slot="details"> {users.length} {$t('my.people')} </span>
	</HeaderLayout>

	<div
		class="flex flex-col border-x  border-b py-3 rounded-b-sm dark:border-zinc-800 dark:bg-zinc-900"
	>
		{#if users?.length > 0}
			<ul class="lg:divide-y dark:lg:divide-zinc-800">
				{#each users as user (user.id)}
					<li class="flex justify-between items-center gap-x-6 py-3 px-3 sm:px-9">
						<div>
							<UserPreview
								{user}
								avatar_size={'w-12 h-12'}
								crown_size={'w-3 h-3'}
								followButton={false}
							/>
						</div>

						<div><FollowButton {user} size="base" /></div>
					</li>
				{/each}
			</ul>
		{:else}
			<p class="px-6 py-3">{$t('my.follow.no_following')}</p>
		{/if}
	</div>
</div>
