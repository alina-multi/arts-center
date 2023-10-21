<script lang="ts">
  import type { User } from '$lib/interfaces/User';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import FollowButton from '../atoms/buttons/FollowButton.svelte';
	import Country from './UserCountry.svelte';
	import OnArtSince from '../atoms/OnArtsSince.svelte';
	import Crown from '../atoms/CrownIcon.svelte';

	export let user: User;

</script>

<div class="w-full">
	<div class="w-full h-32 rounded-sm flex flex-col items-center bg-gray-600 shadow" />
	<div class="border rounded-sm border-t-transparent w-full flex flex-col items-center pb-6">
		<div class=" flex flex-col gap-3 items-center max-sm:w-full w-fit px-6 xs:px-9">
			<div class=" -mt-20">
				<Avatar {user} size={' w-32 h-32  max-xl:w-28 max-xl:h-28 '} />
				{#if user.subscribed}
					<div class="absolute -top-1.5 right-3 p-1.5 bg-amber-500/60 rounded-full">
						<Crown style="{'w-4 h-4'} stroke-white" />
					</div>
				{/if}
			</div>

			<div class="flex gap-3 items-start sm:items-center xl:px-6">
				<p class="text-lg text-center md:text-xl font-semibold text-gray-900 dark:text-gray-100">
					{user.name}
				</p>
			</div>

			<div class="flex flex-col gap-1 xl:px-6 items-center">
				<div class="flex flex-wrap items-center xl:gap-3 gap-1 sm:max-xl:gap-3 xl:justify-center">
					<span>@{user?.username}</span>

					<Country {user} />
				</div>

				<OnArtSince {user} />
			</div>

			<!-- Followers and Supporters buttons for future  -->

			<!-- <div
				class="flex xl:flex-col items-center gap-3 sm:gap-9 xl:gap-3 px-6 font-semibold max-xs:flex-col mb-3"
			>
				<span>Followers 10</span>

				<span>Supporters 234</span>
			</div> -->
			<FollowButton {user} size={'base font-semibold'} />
		</div>
	</div>
</div>
