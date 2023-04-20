<script lang="ts">
	import UserDetails from '$lib/components/user/UserDetails.svelte';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Star, PlusCircle } from '@steeze-ui/heroicons';

	export let user;
</script>

<div class="min-h-full  flex flex-col mx-auto p-6 gap-3 text-base ">
	<div class="flex flex-col gap-3 items-center">
		<Avatar {user} size={' w-28 h-28'} />
		<p class=" text-2xl">{user.name}</p>

		<UserDetails {user} />
		<div class="flex items-center text-gary-800 gap-1 ">
			<Icon src={Star} theme="solid" class=" h-[20px] w-[20px] fill-amber-600 " />
			<span>overall rating:</span>

			<span>{user.rating}</span>
		</div>

		<div class="flex gap-3 flex-wrap text-sm justify-center">
			{#each user.ratings as tag}
				<div class="flex px-2 py-1 border rounded-md gap-1">
					<div>{tag?.tag?.title}</div>
					<span class="bg-amber-600 rounded-full text-white px-1">{tag?.rating}</span>
				</div>
			{/each}
		</div>
	</div>
	<div class="flex justify-center">
		<butoon
			class="flex items-center justify-center gap-1  text-base w-full dark:bg-gray-900 text-center  dark:border-sky-700 dark:border rounded-full py-1 text-white bg-sky-700 font-semibold shadow-sm  hover:bg-sky-600 dark:hover:bg-sky-700 dark:text-gray-100 hover:text-white cursor-pointer"
		>
			<Icon src={PlusCircle} theme="solid" class=" h-[18px] w-[18px] fill-white stroke-sky-600" />
			<span>Follow</span>
		</butoon>
	</div>
</div>
