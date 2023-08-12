<script>
	import { Menu, MenuButton, MenuItems, Transition } from '@rgossiaux/svelte-headlessui';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Bars4 } from '@steeze-ui/heroicons';
	import FooterContent from './FooterContent.svelte';
</script>

<Menu class="relative my-auto text-left block z-50  ">
	<MenuButton class="flex items-center p-1 ">
		<Icon src={Bars4} class="w-7 h-7 stroke-gray-600 dark:stroke-gray-100" />
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
			class="absolute z-50 mt-4 w-72 min-w-max  left-0 rounded-md text-sm text-zinc-600 dark:text-white   bg-white  dark:bg-zinc-800 shadow-2xl ring-1 ring-black dark:ring-zinc-700 ring-opacity-5 focus:outline-none overflow-hidden"
		>
			<FooterContent media="desktop" />
		</MenuItems>
	</Transition>
</Menu>
