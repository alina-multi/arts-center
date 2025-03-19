<script lang="ts">
	import FollowButton from '$lib/components/atoms/buttons/FollowButton.svelte';
	import GetInTouchButton from '$lib/components/atoms/buttons/GetInTouchButton.svelte';
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import UserDetails from '$lib/components/user/UserDetails.svelte';

	export let user, commentable_type, entity;
</script>

<div class=" flex flex-col gap-6 px-4 max-lg:py-6 max-lg:mt-6 lg:px-9">
	<div class="flex items-center gap-6 w-full">
		<AvatarLink {user} size={' w-28 h-28 '} />

		<div class="flex flex-col flex-1 gap-2">
			<div class="flex items-center justify-between gap-3">
				<a href="/" class="flex dark:text-white cursor-pointer items-center gap-2">
					<div
						class="flex items-center flex-wrap gap-2 text-xl lg:text-2xl font-bold lg:font-semibold"
					>
						<span>{user.name}</span>
						<!-- <VerificationBadge user_verified={user.verified_at} /> -->
					</div>
				</a>
			</div>

			<UserDetails {user} />
			<div class=" flex items-start gap-3 text-xs mt-3">
				<div class="h-11">
					<FollowButton
						{user}
						addStyles={' block  py-2 rounded-full  font-semibold border-zinc-800  '}
					/>
				</div>

				<GetInTouchButton {user} origin={{ type: commentable_type, ...entity }} />
			</div>
		</div>
	</div>
</div>
