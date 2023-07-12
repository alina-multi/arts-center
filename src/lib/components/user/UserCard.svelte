<script lang="ts">
	import RatingTags from '$lib/components/user/RatingTags.svelte';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import UserDetails from '$lib/components/user/UserDetails.svelte';
	import FollowButton from '../atoms/FollowButton.svelte';

	export let user;
	$: showRatings = false;
	const onToggle = () => (showRatings = !showRatings);
</script>

<div class=" p-3 lg:p-6 text-sm 2xl:text-base text-gray-700 dark:text-zinc-300">
	<div class="flex xl:flex-col gap-3 items-start sm:items-center">
		<Avatar {user} size={' w-32 h-32  max-sm:w-28 max-sm:h-28 '} />
		<div class="flex flex-col gap-1 xl:items-center w-full">
			<div class="flex gap-3 items-start sm:items-center">
				<p class=" text-xl font-semibold text-gray-900 dark:text-gray-100">
					{user.name}
				</p>
				<span class=" block xl:hidden"><FollowButton {user} size={'xs md:text-sm'} /></span>
			</div>
			<UserDetails {user} full />

			<RatingTags {user} {onToggle} {showRatings} button />
		</div>
	</div>

	<RatingTags {user} {showRatings} tags />

	<div class="hidden xl:flex w-full pt-6">
		<FollowButton {user} size={'sm'} />
	</div>
</div>
