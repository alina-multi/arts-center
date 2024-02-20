<script lang="ts">
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import UserDetails from '$lib/components/user/UserDetails.svelte';
	import { localePath } from '$lib/translations';
	import FollowButton from '$lib/components/atoms/buttons/FollowButton.svelte';
	import Crown from '$lib/components/atoms/CrownIcon.svelte';
	import type { User } from '$lib/interfaces/User';
	import VerificationBadge from '../atoms/VerificationBadge.svelte';
	import { getContext } from 'svelte';

	const locale = getContext('locale');

	export let user: User,
		avatar_size = 'h-16 w-16',
		crown_size = 'w-4 h-4',
		followButton: boolean | undefined = true;

	$: href = localePath($locale, `/${user.username}`);
</script>

<div class="flex items-center gap-3 w-full">
	<div class="relative">
		<AvatarLink {user} size={avatar_size} />

		{#if user.subscribed}
			<div class="absolute -top-1 -left-1 p-1 bg-gray-400/50 rounded-full">
				<Crown style="{crown_size} stroke-white" />
			</div>
		{/if}
	</div>

	<div class="flex flex-col gap-1 flex-1">
		<div class="flex items-center gap-3 max-md:justify-between">
			<a
				{href}
				class="flex hover:text-zinc-800 dark:text-white cursor-pointer text-base items-center gap-2 font-medium"
			>
				<div class="flex gap-2">
					{user.name}
					<VerificationBadge user_verified={user.verified_at} />
				</div>
			</a>
			{#if followButton}
				<span><FollowButton {user} size={'sm'} /></span>
			{/if}
		</div>
		<UserDetails {user} />
	</div>
</div>
