<script lang="ts">
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import UserDetails from '$lib/components/user/UserDetails.svelte';
	import { localePath } from '$lib/translations';
	import type { User } from '$lib/interfaces/User.ts';

	const followButton = 'inline';
	export let user: User;
	$: href = localePath(`/${user.username}`);
</script>

<!-- <div class="flex flex-col gap-2 w-full"> -->
<div class="flex items-center gap-3 w-full">
	<div class="flex-none"><Avatar {user} size={' w-16 h-16'} /></div>

	<div class="flex flex-col gap-1 flex-1 ">
		<div class="flex items-center gap-3 max-md:justify-between">
			<a
				{href}
				class="inline-flex hover:text-gray-800 cursor-pointer  text-base sm:text-lg lg:text-xl xl:text-lg"
				>{user.name}</a
			>
			{#if followButton === 'inline' || !followButton}
				<butoon
					class=" inline-flex dark:bg-gray-900 dark:border-gray-800 dark:border rounded-full px-2 sm:px-3 py-1 text-xs text-white bg-sky-700/90 font-semibold shadow-sm  hover:bg-sky-600 dark:hover:bg-sky-700 dark:text-gray-100 hover:text-white cursor-pointer"
					>Follow</butoon
				>
			{/if}
		</div>

		<UserDetails {user} />
	</div>
</div>
{#if followButton === 'block'}
	<button
		class="  dark:bg-gray-900 text-center  dark:border-sky-700 dark:border rounded-full py-1 text-white bg-sky-700 font-semibold shadow-sm  hover:bg-sky-600 dark:hover:bg-sky-700 dark:text-gray-100 hover:text-white cursor-pointer"
		>Follow
		<span /></button>
{/if}
<!-- </div> -->
