<script lang="ts">
	import UserDetails from '$lib/components/user/UserDetails.svelte';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import {
		Star,
		PlusCircle,
		CalendarDays,
		MapPin,
		Heart,
		Eye,
		EyeSlash
	} from '@steeze-ui/heroicons';
	import { localePath } from '$lib/translations';

	export let user;
	let country;
	if (user?.country?.length === 2) {
		const regionNames = new Intl.DisplayNames(['en'], { type: 'region' });
		country = regionNames.of(user.country);
	}
	let showRatings = false;
</script>

<div class="min-h-full p-3   lg:p-6  sm:text-sm lg:text-base text-xs text-gray-700">
	<div class="flex xl:flex-col gap-3 items-start sm:items-center  ">
		<Avatar {user} size={' w-32 h-32  max-sm:w-28 max-sm:h-28 '} />

		<div class="flex flex-col gap-1 xl:items-center">
			<div class="flex gap-3 items-start ">
				<p class=" text-base sm:text-xl font-semibold text-gray-900">{user.name}</p>
				<butoon
					class="sm:max-xl:flex hidden px-3  items-center justify-center gap-1  text-xs dark:bg-gray-900 text-center  dark:border-sky-700 dark:border rounded-full py-1 text-white bg-sky-700 font-semibold shadow-sm  hover:bg-sky-600 dark:hover:bg-sky-700 dark:text-gray-100 hover:text-white cursor-pointer"
				>
					<span>Follow</span>
				</butoon>
			</div>

			<div class="flex flex-col sm:max-xl:flex-row sm:max-xl:gap-3 gap-1 xl:items-center">
				<div class="flex flex-wrap items-center  gap-1 sm:gap-3">
					<span>@{user?.username}</span>

					{#if country}
						<div class="inline-flex  items-center">
							<Icon src={MapPin} class=" h-[17px] w-[17px]  dark:stroke-gray-300" />
							<span>{country}</span>
						</div>
					{/if}
				</div>

				<div class="flex gap-1 items-center   ">
					<Icon src={CalendarDays} class=" h-[17px] w-[17px]  " />
					<span>on arts since: </span>
					<span> {new Date(user.created_at).getFullYear()}</span>
				</div>
			</div>
			<div class="flex items-center gap-1 ">
				<Icon
					src={Star}
					theme="solid"
					class=" xl:h-[19px] xl:w-[19px] w-4 h-4 fill-amber-600 stroke-amber-600 "
				/>
				<span>Total rating: </span>
				<span>4540</span>
			</div>
			<div class="flex flex-wrap gap-2  ">
				<span>Rating by category:</span>

				<button
					class="flex xl:hidden gap-1 font-semibold items-center   text-gray-800  hover:text-gray-600"
					on:click={() => (showRatings = !showRatings)}
				>
					{#if !showRatings}
						<span>View</span>
						<Icon src={Eye} theme="solid" class=" h-4 w-4 " />
					{:else}
						<span>Hide</span>
						<Icon src={EyeSlash} theme="solid" class=" h-4 w-4 transform rotate-180" />
					{/if}
				</button>
			</div>
		</div>
	</div>
	<div
		class="{showRatings
			? 'flex'
			: 'hidden xl:flex'}  flex-wrap items-center xl:justify-center gap-3 mt-3 sm:text-sm lg:text-base text-xs"
	>
		{#each user.ratings as tag}
			<div
				class="flex  items-center gap-1  border  rounded-full  px-2 xl:px-3 cursor-pointer hover:shadow-sm hover:border-amber-500"
			>
				<a href={localePath(`/${user.username}/tag/${tag?.tag?.title}`)}>{tag?.tag?.title}</a>
				<Icon src={Heart} class=" h-3 w-3 lg:w-4 lg:h-4" />
				<span> {tag?.rating}</span>
			</div>
		{/each}
	</div>

	<butoon
		class="mt-3 sm:max-xl:hidden flex items-center justify-center gap-1  text-sm sm:text-base w-full dark:bg-gray-900 text-center  dark:border-sky-700 dark:border rounded-full py-1 text-white bg-sky-700 font-semibold shadow-sm  hover:bg-sky-600 dark:hover:bg-sky-700 dark:text-gray-100 hover:text-white cursor-pointer"
	>
		<Icon src={PlusCircle} theme="solid" class=" h-[18px] w-[18px] fill-white stroke-sky-600" />
		<span>Follow</span>
	</butoon>
</div>
