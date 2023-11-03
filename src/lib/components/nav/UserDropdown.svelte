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
		<Avatar user={user} size="h-10 w-10" />
	</slot:fragment>

	<slot:fragment slot="panel">
		<ul>
			{#if user.approved_at}
			<MyPageLink href={'/' + user?.username} />
			{/if}
			<MyProfileLinksGroup />
			<li>
				<LogoutButton />
			</li>
		</ul>
	</slot:fragment>
</Dropdown>
