<script lang="ts">
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import UserDetails from '$lib/components/user/UserDetails.svelte';
	import { localePath } from '$lib/translations';
	import type { User } from '$lib/interfaces/User.ts';

	import FollowButton from '$lib/components//atoms/FollowButton.svelte';

	export let user, followBtn;

	$: href = localePath(`/${user.username}`);
</script>

<div class="flex items-center gap-3 w-full">
	<Avatar {user} size={' w-16 h-16'} />

	<div class="flex flex-col gap-1 flex-1">
		<div class="flex items-center gap-3 max-md:justify-between">
			<a
				{href}
				class="inline-flex hover:text-gray-800 cursor-pointer text-base sm:text-lg lg:text-xl xl:text-lg"
				>{user.name}</a
			>
			{#if !followBtn}
				<FollowButton {user} size={'xs'} />
			{/if}
		</div>

		<UserDetails {user} />
	</div>
</div>
{#if followBtn === 'block'}
	<FollowButton {user} size={'base w-full'} />
{/if}
