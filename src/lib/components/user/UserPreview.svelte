<script lang="ts">
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import UserDetails from '$lib/components/user/UserDetails.svelte';
	import { localePath } from '$lib/translations';
	import FollowButton from '$lib/components//atoms/FollowButton.svelte';
	import Crown from '$lib/components/atoms/CrownIcon.svelte';
	export let user;

	$: href = localePath(`/${user.username}`);
</script>

<div class="flex items-center gap-3 w-full py-3">
	<div class="relative">
		<Avatar {user} size={'h-16 w-16'} />

		{#if user.subscribed}
			<div class="absolute -top-1 -left-1 p-1 bg-gray-400/50 rounded-full">
				<Crown style="w-4 h-4 stroke-white" />
			</div>
		{/if}
	</div>

	<div class="flex flex-col gap-1 flex-1">
		<div class="flex items-center gap-3 max-md:justify-between">
			<a
				{href}
				class="inline-flex hover:text-zinc-800 dark:hover:text-zinc-300 cursor-pointer text-base"
				>{user.name}</a
			>
			<span><FollowButton {user} size={'sm xl:text-xs'} /></span>
		</div>
		<UserDetails
			{user}
			wrap="flex flex-wrap text-sm text-gray-500 dark:text-gray-300 gap-1 md:gap-2 items-center"
		/>
	</div>
</div>
