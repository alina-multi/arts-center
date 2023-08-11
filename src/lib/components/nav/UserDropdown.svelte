<script lang="ts">
	import type { User } from '$lib/interfaces/User';
	import { Menu, MenuButton, MenuItems, Transition } from '@rgossiaux/svelte-headlessui';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Home } from '@steeze-ui/heroicons';
	import Avatar from '../atoms/Avatar.svelte';
	import MyProfileLinksGroup from '../user/MyProfileLinksGroup.svelte';
	import SideNavLink from '$lib/components/nav/side/SideNavLink.svelte';
	import LogoutButton from '../atoms/LogoutButton.svelte';
	export let user: User;
</script>

<Menu class="relative my-auto text-left block z-30  ">
	<MenuButton class="flex items-center p-1 ">
		<Avatar {user} size={'w-10 h-10 '} />
	</MenuButton>
	<Transition
		enter="transition ease-out duration-100"
		enterFrom="transform opacity-0 scale-95"
		enterTo="transform opacity-100 scale-100"
		leave="transition ease-in duration-75"
		leaveFrom="transform opacity-100 scale-100"
		leaveTo="transform opacity-0 scale-95"
	>
		<MenuItems
			class=" absolute z-50 mt-2 w-60 -right-[60px] py-2 rounded-md text-sm text-zinc-600 dark:text-white   bg-white  dark:bg-zinc-800 shadow-2xl ring-1 ring-black dark:ring-zinc-700 ring-opacity-5 focus:outline-none overflow-hidden"
		>
			<ul>
				<SideNavLink href="/{user?.username}"
					><Icon src={Home} theme="solid" class="h-5 w-5 inline" aria-hidden="true" />My Page</SideNavLink
				>
				<MyProfileLinksGroup />

				<li>
					<LogoutButton />
				</li>
			</ul>
		</MenuItems>
	</Transition>
</Menu>
