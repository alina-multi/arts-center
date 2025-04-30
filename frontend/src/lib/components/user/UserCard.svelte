<script lang="ts">
	import type { User } from '$lib/interfaces/User';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import FollowButton from '../atoms/buttons/FollowButton.svelte';
	import Country from './UserCountry.svelte';
	import OnArtSince from '../atoms/OnArtsSince.svelte';
	import VerificationBadge from '../atoms/VerificationBadge.svelte';
	import GetInTouchButton from '$lib/components/atoms/buttons/GetInTouchButton.svelte';
	import { user as currentUser } from '$lib/stores/auth';
	import { handleIsMy } from '$lib/helpers/handleIsMy';
	import AvatarEditLink from '$lib/components/user/AvatarEditLink.svelte';

	let isMy = false;
	$: isMy = handleIsMy($currentUser, user.id);

	export let user: User;
</script>

<div class="w-full">
	<div
		class="w-full h-32 rounded-t-sm flex flex-col items-center bg-zinc-900 dark:bg-zinc-900 dark:border dark:border-zinc-800"
	/>
	<div
		class=" bg-zinc-50 rounded-b-sm border-x border-b dark:border-zinc-800 dark:border-t-transparent w-full pb-9 dark:bg-zinc-950"
	>
		<div class=" flex flex-col gap-3 items-center w-full px-6 xs:px-9">
			<div class=" -mt-20">
				{#if isMy}
			<AvatarEditLink user={$currentUser} size={' w-32 h-32  max-xl:w-28 max-xl:h-28 '} />
			{:else}
				<Avatar {user} size={' w-32 h-32  max-xl:w-28 max-xl:h-28 '} /> 
				{/if}
			</div>

			<div class="flex gap-3 items-start sm:items-center xl:px-6">
				<p
					class=" text-center text-xl font-medium text-black dark:text-zinc-100 flex gap-2 items-center"
				>
					{user.name}
					<VerificationBadge user_verified={user.verified_at} size="w-6 h-6" />
				</p>
			</div>

			<div class="flex flex-col gap-1 xl:px-6 items-center">
				<span>@{user?.username}</span>

				<Country {user} />

				<OnArtSince {user} />
			</div>
			<div class="grid grid-cols-2 gap-6 w-full items-center mt-6 h-11">
				<FollowButton
					{user}
					addStyles={'rounded-full text-base border-zinc-800  text-center font-medium   py-2 block'}
				/>

				<GetInTouchButton {user} />
			</div>
		</div>
	</div>
</div>
