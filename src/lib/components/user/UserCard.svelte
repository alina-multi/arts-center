<script lang="ts">
	import RatingTags from '$lib/components/user/RatingTags.svelte';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import UserDetails from '$lib/components/user/UserDetails.svelte';

	export let user;
	$: showRatings = false;
	const onToggle = () => (showRatings = !showRatings);
</script>

<div class=" p-3   lg:p-6  sm:text-sm 2xl:text-base  text-xs text-gray-700 dark:text-gray-300">
	<div class="flex xl:flex-col gap-3 items-start sm:items-center  ">
		<Avatar {user} size={' w-32 h-32  max-sm:w-28 max-sm:h-28 '} />
		<div class="flex flex-col gap-1 xl:items-center w-full">
			<div class="flex gap-3 items-start ">
				<p class=" text-base sm:text-xl font-semibold text-gray-900 dark:text-gray-100">
					{user.name}
				</p>
				<!-- Add FOOLOW BUTTON component here -->
				<!-- <butoon
					class="sm:max-xl:flex hidden px-3  items-center justify-center gap-1  text-xs dark:bg-gray-900 text-center  dark:border-sky-700 dark:border rounded-full py-1 text-white bg-sky-700 font-semibold shadow-sm  hover:bg-sky-600 dark:hover:bg-sky-700 dark:text-gray-100 hover:text-white cursor-pointer"
				>
					<span>Follow</span>
				</butoon> -->
			</div>
			<UserDetails {user} full />

			<RatingTags {user} {onToggle} {showRatings} button />
		</div>
	</div>

	<RatingTags {user} {showRatings} tags />
	<!-- Add FOOLOW BUTTON component here -->
	<!-- <butoon
		class="mt-3 xl:mt-6 sm:max-xl:hidden flex items-center justify-center gap-1  text-sm sm:text-base w-full dark:bg-gray-900 text-center  dark:border-sky-700 dark:border rounded-full py-1 text-white bg-sky-700 font-semibold shadow-sm  hover:bg-sky-600 dark:hover:bg-sky-700 dark:text-gray-100 hover:text-white cursor-pointer"
	>
		<Icon src={PlusCircle} theme="solid" class="  w-[18px] fill-white stroke-sky-600" />
		<span>Follow</span>
	</butoon> -->
</div>
