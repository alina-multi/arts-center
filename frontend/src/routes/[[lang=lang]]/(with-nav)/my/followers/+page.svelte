<script lang="ts">
	import UserPreview from '$lib/components/user/UserPreview.svelte';
	import HeaderLayout from '$lib/components/my/HeaderLayout.svelte';
	import FollowButton from '$lib/components/atoms/buttons/FollowButton.svelte';
	import { getContext } from 'svelte';

	const t = getContext('t');

	export let data;
	let followers = data.followers;
	followers = [];
</script>

<div>
	<HeaderLayout title={$t('my.follow.followers')}>
		<div slot="details" class="flex gap-3 items-center leading-3">
			{followers.length}
			{$t('my.people')}
		</div>
	</HeaderLayout>

	<div class="flex flex-col dark:border-zinc-800 dark:bg-zinc-900">
		{#if followers?.length > 0}
			<ul class="lg:divide-y dark:lg:divide-zinc-800">
				{#each followers as user (user.id)}
					<li class="flex justify-between items-center gap-x-6 py-3 px-3 sm:px-9">
						<div>
							<UserPreview
								{user}
								avatar_size={'w-12 h-12'}
								crown_size={'w-3 h-3'}
								followButton={false}
							/>
						</div>

						<div><FollowButton {user} addStyles="text-base" /></div>
					</li>
				{/each}
			</ul>
		{:else}
			<p class="px-6 py-3">{$t('my.follow.no_followers')}</p>
		{/if}
	</div>
</div>
