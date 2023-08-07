<script>
	import { Menu, MenuButton, MenuItems, MenuItem, Transition } from '@rgossiaux/svelte-headlessui';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { PencilSquare, Bars4 } from '@steeze-ui/heroicons';
	import { localePath, t } from '$lib/translations';
	import { page } from '$app/stores';
	import TopNavLangLink from '$lib/components/nav/TopNavLangLink.svelte';
</script>

<Menu class="relative my-auto text-left block z-30  ">
	<MenuButton class="flex items-center p-1 ">
		<button>
			<Icon src={Bars4} class="w-7 h-7 stroke-gray-600 dark:stroke-gray-100" />
		</button>
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
			class="absolute z-50 mt-4 w-72 min-w-max  -right-[60px]  rounded-md text-sm text-zinc-600 dark:text-white   bg-white  dark:bg-zinc-800 shadow-2xl ring-1 ring-black dark:ring-zinc-700 ring-opacity-5 focus:outline-none overflow-hidden"
		>
			<div class="flex items-stretch gap-3 border-b dark:border-zinc-700 w-full px-9 h-12">
				<TopNavLangLink lang="en" />
				<TopNavLangLink lang="uk" />
			</div>
			<div class="flex items-start px-9 py-6 gap-12">
				<div class="">
					<h1 class="font-semibold mb-3">About</h1>
					<ul class="space-y-2">
						<li>
						<a href={localePath('/about')}>{$t('global.footer.about')}</a>
						</li>
						<li><a href={localePath('/contacts')}>{$t('global.footer.contacts')}</a></li>
						<li><a href={localePath('/blog')}>{$t('global.footer.blog')}</a></li>
					</ul>
				</div>

				<div>
					<h1 class="font-semibold mb-3">Pricing</h1>
					<ul class="space-y-2">
						<li>
							<a href={localePath('/subscriptions')}>{$t('global.footer.subscriptions')}</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="flex items-center border-t dark:border-zinc-700 text-xs gap-9 px-6 py-3">
				<a href={localePath('/privacy')}>{$t('global.footer.privacy')}</a>
				<a href={localePath('/terms')}>{$t('global.footer.terms')}</a>
			</div>
		</MenuItems>
	</Transition>
</Menu>
