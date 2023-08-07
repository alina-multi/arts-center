<script lang="ts">
	import type { User } from '$lib/interfaces/User';
	import { Menu, MenuButton, MenuItems, MenuItem, Transition } from '@rgossiaux/svelte-headlessui';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { PencilSquare } from '@steeze-ui/heroicons';
	import { localePath } from '$lib/translations';
	import { page } from '$app/stores';
	import Avatar from '../atoms/Avatar.svelte';
	export let user: User;

</script>

<Menu class="relative my-auto text-left block z-30  ">
	<MenuButton class="flex items-center p-1 ">
		<Avatar {user} size={'w-10 h-10 '}   />
	
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
			class=" absolute z-50 mt-2 w-40 -right-[60px] py-2 rounded-md text-sm text-zinc-600 dark:text-white   bg-white  dark:bg-zinc-800 shadow-2xl ring-1 ring-black dark:ring-zinc-700 ring-opacity-5 focus:outline-none overflow-hidden"
		>
			<MenuItem let:active>
				<a
					href={localePath(`/${user?.username}`)}
					class="{active ? 'bg-gray-100 dark:bg-zinc-700' : ''} block px-6 py-2 font-semibold"
					>My profile</a
				>
			</MenuItem>
			<MenuItem let:active>
				<a
					href={localePath('/my/profile')}
					class="{active
						? 'bg-gray-100 dark:bg-zinc-700'
						: ''}  px-6 py-2 font-semibold flex items-center gap-2"
				>
					<span>Edit profile</span>
					<Icon src={PencilSquare} theme="solid" class="w-4 mb-0.5" />
				</a>
			</MenuItem>
			<MenuItem let:active>
				<a
					href={localePath('/logout?redirect=' + $page.url.pathname)}
					class="{active ? 'bg-gray-100 dark:bg-zinc-700' : ''} block px-6 py-2 font-semibold"
					data-sveltekit-preload-data="tap"
					data-sveltekit-reload
					>Logout &rarr;
				</a>
			</MenuItem>
		</MenuItems>
	</Transition>
</Menu>
