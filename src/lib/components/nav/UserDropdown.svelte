<script>
	import { Menu, MenuButton, MenuItem, MenuItems, Transition } from '@rgossiaux/svelte-headlessui';
	import { localePath } from '$lib/translations';
	import { page } from '$app/stores';

	export let user;
</script>

<Menu class="flex items-center p-1">
	<MenuButton>
		<img
			src={user.avatar.src}
			srcset={user.avatar.srcset}
			alt={user.name}
			class="flex-none h-6 w-6 rounded-full object-cover"
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
			class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
		>
			<MenuItem let:active>
				<a
					href={localePath('/profile')}
					class={`${(active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700')}`}
					>Edit profile</a
				>
			</MenuItem>
			<MenuItem let:active>
				<a
					href={localePath('/logout?redirect=' + $page.url.pathname)}
					class={`${(active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700')}`}
					data-sveltekit-preload-data="tap"
					data-sveltekit-reload>Logout</a
				>
			</MenuItem>
		</MenuItems>
	</Transition>
</Menu>
