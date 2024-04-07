<script lang="ts">
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import UserDetails from '$lib/components/user/UserDetails.svelte';
	import { localePath } from '$lib/translations';
	import FollowButton from '$lib/components/atoms/buttons/FollowButton.svelte';
	import type { User } from '$lib/interfaces/User';
	import VerificationBadge from '../atoms/VerificationBadge.svelte';
	import { getContext } from 'svelte';

	const locale = getContext('locale');

	export let user: User,
		avatar_size = 'h-12 w-12 xs:h-16 xs:w-16 lg:max-xl:h-12 lg:max-xl:w-12 xl:h-14 xl:w-14 ',
		followButton: boolean | undefined = true;

	$: href = localePath($locale, `/${user.username}`);
</script>

<div class="flex items-center gap-3 w-full ">
	<AvatarLink {user} size={avatar_size} />

	<div class="flex flex-col flex-1">
		<div class="flex items-center justify-between gap-6 lg:gap-3">
			<a
				{href}
				class="flex dark:text-white cursor-pointer text-base items-center gap-2 "
			>
				<div class="flex items-center flex-wrap gap-2  max-sm:text-sm text-base xl:text-sm font-semibold">
					<span>{user.name}</span>
					<VerificationBadge user_verified={user.verified_at} />
				</div>
			</a>
			{#if followButton}
				<FollowButton
					{user}
					size={'sm max-sm:text-xs xl:text-xs   border border border-zinc-500 border-zinc-800 text-zinc-800 dark:bg-zinc-800  w-min px-3 py-1 text-center'}
				/>
			{/if}
		</div>
		<UserDetails {user} />
	</div>
</div>
