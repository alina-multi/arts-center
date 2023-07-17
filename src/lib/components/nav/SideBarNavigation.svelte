<script lang="ts">
	import {
		Dialog,
		DialogOverlay,
		DialogDescription,
		Transition
	} from '@rgossiaux/svelte-headlessui';
	import { localePath, t } from '$lib/translations';
	import Button from '../atoms/Button.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Bars4, XMark, PencilSquare } from '@steeze-ui/heroicons';
	import TopNav from './top/TopNav.svelte';
	import TopNavLangLink from './TopNavLangLink.svelte';
	import Logo from '../atoms/Logo.svelte';
	import AddWorkLink from './AddWorkLink.svelte';
	import LoginLink from './LoginLink.svelte';
	import TopNavLink from './TopNavLink.svelte';

	import Avatar from '../atoms/Avatar.svelte';
	import { page } from '$app/stores';

	let currentUser = $page.data.currentUser;
	export let open = false;


</script>

<Button on:open={() => (open = !open)} type={'button'}>
	<span class="sr-only">Open main menu</span>
	<Icon src={Bars4} theme="solid" class="h-8 w-8 fill-black dark:fill-white" aria-hidden="true" />
</Button>


<div >
	<Dialog {open} on:close={() => (open = !open)} class="relative xl:hidden " initialFocus>
		<Transition
			show={open}
			class="fixed inset-0 overflow-hidden z-30"
			enter="transition ease-in-out duration-200 transform"
			enterFrom="-translate-x-full"
			enterTo="translate-x-0"
			leave="transition ease-in-out duration-1000 transform"
			leaveFrom="translate-x-0"
			leaveTo="translate-x-full"
		>
			<DialogOverlay class="fixed inset-0 bg-zinc-900/50 z-50" />
	
			<div
				class="absolute inset-y-0 z-50 left-0 w-full sm:w-2/3 md:w-1/2 overflow-y-auto bg-white dark:bg-zinc-900 text-black dark:text-white"
			>
				<DialogDescription>
					<TopNav>
						<Logo />
						<div class="flex items-center gap-3 ml-6 h-full">
							<TopNavLangLink lang="en" />
							<TopNavLangLink lang="uk" />
	
							<Button on:close={() => (open = !open)} type={'button'} customClass="ml-6">
								<span class="sr-only">Close main menu</span>
								<Icon src={XMark} theme="solid" class="h-7 w-7" aria-hidden="true" />
							</Button>
						</div>
					</TopNav>
	
					<div class="divide-y dark:divide-zinc-800">
						<div class="flex flex-col p-6 gap-6 w-full">
							<TopNavLink media={'mobile'} exact href={localePath('/')}>{$t('global.menu.gallery')}</TopNavLink>
							<TopNavLink media={'mobile'}  href={localePath('/users')}>{$t('global.menu.users')}</TopNavLink>
						</div>
	
						{#if currentUser}
							<div class="flex flex-col gap-3 py-3 divide-y dark:divide-zinc-800">
								<div class="flex justify-between gap-3 pl-6 pr-3 min-[500px]:pr-6 items-center w-full">
									<Avatar user={currentUser} size={'w-10 h-10 '} withName />
									<AddWorkLink />
								</div>
								<div class=" flex flex-col pl-16 px-3 gap-6 py-3">
									<a href={localePath('/my/profile')} class="flex items-center gap-2">
										<span >Edit profile</span>
										<Icon src={PencilSquare} class="w-5 mb-0.5" />
									</a>
									<a
										href={localePath('/logout?redirect=' + $page.url.pathname)}
										data-sveltekit-preload-data="tap"
										data-sveltekit-reload>Log Out &rarr;
										</a
									>
								</div>
							</div>
						{:else}
							<div class="flex items-center py-6 justify-center gap-6">
								<AddWorkLink />
								<LoginLink />
							</div>
						{/if}
	
						<div />
					</div>
				</DialogDescription>
			</div>
		</Transition>
	</Dialog>
</div>





