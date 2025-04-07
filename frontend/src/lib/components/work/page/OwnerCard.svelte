<script lang="ts">
	import FollowButton from '$lib/components/atoms/buttons/FollowButton.svelte';
	import GetInTouchButton from '$lib/components/atoms/buttons/GetInTouchButton.svelte';
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import UserDetails from '$lib/components/user/UserDetails.svelte';
	import VerificationBadge from '$lib/components/atoms/VerificationBadge.svelte';
	import { getContext } from 'svelte';
	import { localePath } from '$lib/translations';
	import MoreWorksFromUser from '$lib/components/work/page/MoreWorksFromUser.svelte';
	import DonateForm from '$lib/components/atoms/DonateForm.svelte';

	export let user, commentable_type, entity;

	const locale = getContext('locale');
	$: href = localePath($locale, `/${user?.username}`);
</script>

<div>
	<div
		class="flex items-center gap-6 w-full py-9 px-4 sm:p-9 bg-zinc-100 dark:bg-zinc-900 max-xl:dark:border-y dark:border-zinc-800"
	>
		<AvatarLink {user} size={' w-28 h-28 '} />
		<div>
			<div class="flex flex-col flex-1 gap-2">
				<div class="flex items-center justify-between gap-3">
					<a {href} class="flex dark:text-white cursor-pointer items-center gap-2">
						<div
							class="flex items-center flex-wrap gap-2 text-xl lg:text-2xl font-bold lg:font-semibold"
						>
							<span>{user.name}</span>
							<VerificationBadge user_verified={user.verified_at} />
						</div>
					</a>
				</div>

				<UserDetails {user} />
			</div>

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

	{#if user.verified_at}
		<div class="block xl:hidden"><DonateForm {user} /></div>
	{/if}

	{#if user.last_works?.length}
		<MoreWorksFromUser {user} />
	{/if}
</div>
