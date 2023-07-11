<script>
	import { Menu, MenuButton, MenuItems, MenuItem, Transition } from '@rgossiaux/svelte-headlessui';
	import { localePath } from '$lib/translations';
	import { page } from '$app/stores';

	export let user;
</script>

<Menu class="relative my-auto text-left block z-30  ">
	<MenuButton class="flex items-center p-1">
		<img
			src={user?.avatar?.src}
			srcset={user?.avatar?.srcset}
			alt={user?.name}
			class="flex-none h-7 w-7 rounded-full object-cover border border-gray-100 dark:border-zinc-800"
		/>
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
			class=" absolute z-50 mt-2 w-40 -right-[60px]  rounded-md text-gray-700 dark:text-white  bg-white dark:bg-zinc-800 shadow-2xl ring-1 ring-black dark:ring-zinc-700 ring-opacity-5 focus:outline-none overflow-hidden"
		>
			<MenuItem let:active>
				<a
					href={localePath('/my/profile')}
					class="{active ? 'bg-gray-100 dark:bg-zinc-800' : ''} block px-4 py-2">Edit profile</a
				>
			</MenuItem>
			<MenuItem let:active>
				<a
					href={localePath('/logout?redirect=' + $page.url.pathname)}
					class="{active ? 'bg-gray-100 dark:bg-zinc-800' : ''} block px-4 py-2"
					data-sveltekit-preload-data="tap"
					data-sveltekit-reload>Logout</a
				>
			</MenuItem>
		</MenuItems>
	</Transition>
</Menu>
