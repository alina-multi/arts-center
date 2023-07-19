<script lang="ts">
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import UserDetails from '$lib/components/user/UserDetails.svelte';
	import { localePath } from '$lib/translations';

	import FollowButton from '$lib/components//atoms/FollowButton.svelte';

	export let user, followBtn;

	$: href = localePath(`/${user.username}`);
</script>

<div class="flex items-center gap-3 w-full">
	<Avatar {user} size={'h-16 w-16'} />

	<div class="flex flex-col gap-1 flex-1">
		<div class="flex items-center gap-3 max-md:justify-between">
			<a
				{href}
				class="inline-flex hover:text-zinc-800 dark:hover:text-zinc-300 cursor-pointer text-base"
				>{user.name}</a
			>
			{#if !followBtn}
				<span><FollowButton {user} size={'xs'} /></span>
			{/if}
		</div>

		<UserDetails {user} />
	</div>
</div>
{#if followBtn === 'block'}
	<FollowButton {user} size={'sm'} />
{/if}
