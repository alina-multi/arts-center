<script lang="ts">
	import type { User } from '$lib/interfaces/User';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Home } from '@steeze-ui/heroicons';
	import Avatar from '../atoms/Avatar.svelte';
	import MyProfileLinksGroup from '../user/MyProfileLinksGroup.svelte';
	import SideNavLink from '$lib/components/nav/side/SideNavLink.svelte';
	import LogoutButton from '../atoms/LogoutButton.svelte';
	import Dropdown from '../atoms/Dropdown.svelte';
	export let user: User;
</script>

<Dropdown style="-right-[60px]  z-50 w-60  text-sm mt-2">
	<slot:fragment slot="button">
		<Avatar {user} size={'w-10 h-10 '} />
	</slot:fragment>

	<slot:fragment slot="panel">
		<ul>
			<SideNavLink href="/{user?.username}"
				><Icon src={Home} theme="solid" class="h-5 w-5 inline" aria-hidden="true" />My Page</SideNavLink
			>
			<MyProfileLinksGroup />

			<li>
				<LogoutButton />
			</li>
		</ul></slot:fragment
	>
</Dropdown>
