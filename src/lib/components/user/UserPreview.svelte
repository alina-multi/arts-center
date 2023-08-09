<script lang="ts">
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import UserDetails from '$lib/components/user/UserDetails.svelte';
	import { localePath } from '$lib/translations';
	import FollowButton from '$lib/components//atoms/FollowButton.svelte';
	export let user;

	$: href = localePath(`/${user.username}`);
</script>

<div class="flex items-center gap-3 w-full py-3">
	<div class="relative ">
		<Avatar {user} size={'h-16 w-16'} />
		
	{#if user.subscribed}
	<div class="absolute -top-1 -left-1 p-1 bg-gray-400/50 rounded-full">
		<svg
		class="w-4 h-4 lucide lucide-crown  stroke-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m2 4 3 12h14l3-12-6 7-4-7-4 7-6-7zm3 16h14"/></svg>
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
			<span><FollowButton {user} size={'xs'} /></span>
		</div>
		<UserDetails
			{user}
			wrap="flex flex-wrap text-sm text-gray-500 dark:text-gray-300 gap-1 md:gap-2 items-center"
		/>
	</div>
</div>
