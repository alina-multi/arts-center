<script lang="ts">
	import type { User } from '$lib/interfaces/User';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import FollowButton from '../atoms/buttons/FollowButton.svelte';
	import Country from './UserCountry.svelte';
	import OnArtSince from '../atoms/OnArtsSince.svelte';
	import VerificationBadge from '../atoms/VerificationBadge.svelte';
	import GetInTouchButton from '$lib/components/atoms/buttons/GetInTouchButton.svelte';

	export let user: User;
</script>

<div class="w-full">
	<div
		class="w-full h-32 rounded-t-sm flex flex-col items-center bg-zinc-800 dark:bg-zinc-900 dark:border dark:border-zinc-800"
	/>
	<div
		class=" bg-zinc-50 rounded-b-sm border-x border-b dark:border-zinc-800 dark:border-t-transparent w-full pb-9 dark:bg-zinc-950"
	>
		<div class=" flex flex-col gap-3 items-center w-full px-6 xs:px-9">
			<div class=" -mt-20">
				<Avatar {user} size={' w-32 h-32  max-xl:w-28 max-xl:h-28 '} />
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
				<div class="flex flex-wrap items-center xl:gap-3 gap-1 sm:gap-2 xl:justify-center">
					<span>@{user?.username}</span>

					<Country {user} />
				</div>

				<OnArtSince {user} />
			</div>
			<div class="flex grid-cols-2 gap-6 w-full items-center mt-6 h-11 ">
				<FollowButton
					{user}
					addStyles={'text-base border-zinc-800  bg-white   text-center font-medium  w-full py-2 block'}
				/>

				<GetInTouchButton {user}  />
			</div>
		</div>
	</div>
</div>
