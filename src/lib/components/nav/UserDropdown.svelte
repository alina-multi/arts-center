<script lang="ts">
	import type { User } from '$lib/interfaces/User';
	import MyProfileLinksGroup from './MyProfileLinksGroup.svelte';
	import LogoutButton from '../atoms/buttons/LogoutButton.svelte';
	import Dropdown from '../atoms/Dropdown.svelte';
	import Avatar from '../atoms/Avatar.svelte';
	import MyPageLink from '../atoms/MyPageLink.svelte';

	
	export let user: User;
</script>

<Dropdown style="-right-[60px]  z-40 w-60  text-sm mt-2" z={30}>
	<slot:fragment slot="button">
		<div class='relative'>
		<Avatar user={user} size="h-10 w-10" />
			<div class='absolute right-0 bottom-0 bg-amber-500/50 rounded-full w-6 h-6'>{user.unread}</div>
		</div>
	</slot:fragment>

	<slot:fragment slot="panel">
		<ul>
			{#if user.approved_at}
			<MyPageLink href={'/' + user?.username} />
			{/if}
			<MyProfileLinksGroup {user} />
			<li>
				<LogoutButton />
			</li>
		</ul>
	</slot:fragment>
</Dropdown>
