<script lang="ts">
	import RatingTags from '$lib/components/user/RatingTags.svelte';
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import FollowButton from '../atoms/Buttons/FollowButton.svelte';
	import Country from './UserCountry.svelte';
	import TotalRating from './TotalRating.svelte';
	import OnArtSince from '../atoms/OnArtsSince.svelte';
	import Crown from '../atoms/CrownIcon.svelte';

	export let user;
	$: showRatings = false;
	const onToggle = () => (showRatings = !showRatings);
</script>

<div
	class="px-3 sm:px-6 xl:px-0 py-3 lg:py-6 text-sm 2xl:text-base text-gray-700 dark:text-zinc-300"
>
	<div
		class="flex xl:flex-col gap-3 items-start {showRatings ? ' items-start ' : 'sm:items-center'}"
	>
	<div class="relative">
		<AvatarLink {user} size={' w-32 h-32  max-xl:w-28 max-xl:h-28'} />
		{#if user.subscribed}
			<div class="absolute -top-1.5 right-3 p-1.5 bg-amber-500/60 rounded-full">
				<Crown style="{"w-4 h-4"} stroke-white" />
			</div>
		{/if}
	</div>

		<div class="flex flex-col gap-1 xl:items-center w-full">
			<div class="flex gap-3 items-start sm:items-center xl:px-6">
				<p class="text-lg md:text-xl font-semibold text-gray-900 dark:text-gray-100">
					{user.name}
				</p>
				<span class="block xl:hidden"><FollowButton {user} size={'sm'} /></span>
			</div>
			<div class="flex flex-col sm:max-xl:flex-row sm:max-xl:gap-3 gap-1 xl:items-center xl:px-6">
				<div class="flex flex-wrap items-center xl:gap-2 gap-1 sm:max-xl:gap-3 xl:justify-center">
					<span>@{user?.username}</span>

					<Country {user} />
				</div>

				<OnArtSince {user} />
			</div>

			<span class="hidden xl:block my-2 w-1/2"><FollowButton {user} size={'sm'} /></span>

			<div class="hidden xl:block border-b h-1 dark:border-zinc-800 w-full my-2" />
			<div class=""><TotalRating {user} full /></div>

			<div class="w-full xl:text-base xl:px-9 xl:mt-2">
				<RatingTags {user} {onToggle} {showRatings} />
			</div>
		</div>
	</div>
</div>
