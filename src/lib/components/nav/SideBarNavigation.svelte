<script lang="ts">
	import {
		Dialog,
		DialogOverlay,
		DialogDescription,
		Transition,
		TransitionChild
	} from '@rgossiaux/svelte-headlessui';
	import { localePath, t } from '$lib/translations';
	import Button from '../atoms/Button.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Bars4, XMark } from '@steeze-ui/heroicons';
	import TopNav from './top/TopNav.svelte';
	import TopNavLangLink from './TopNavLangLink.svelte';
	import Logo from '../atoms/Logo.svelte';
	import AddWorkLink from './AddWorkLink.svelte';
	import LoginLink from './LoginLink.svelte';
	import TopNavLink from './TopNavLink.svelte';
	import MyProfileLinksGroup from '../user/MyProfileLinksGroup.svelte';
	import LogoutButton from '../atoms/LogoutButton.svelte';

	import Avatar from '../atoms/Avatar.svelte';
	import { page } from '$app/stores';
	import FooterContent from '../footer/FooterContent.svelte';

	let currentUser = $page.data.currentUser;
	export let open = false;
</script>

<Button on:click={() => (open = !open)} type={'button'}>
	<span class="sr-only">Open main menu</span>
	<Icon src={Bars4} theme="solid" class="h-8 w-8 fill-black dark:fill-white" aria-hidden="true" />
</Button>

<div>
	<Transition show={open}>
		<Dialog {open} on:close={() => (open = !open)} class="relative xl:hidden " initialFocus>
			<TransitionChild
				class="fixed inset-0 z-40 "
				enter="transition-opacity ease-linear duration-300"
				enterFrom="opacity-0"
				enterTo="opacity-100"
				leave="transition-opacity ease-linear duration-300"
				leaveFrom="opacity-100"
				leaveTo="opacity-0"
			>
				<DialogOverlay class="fixed inset-0 z-40 bg-zinc-900/50 " />
			</TransitionChild>
			<TransitionChild
				class="fixed top-0 left-0 h-screen  z-50 w-full sm:w-2/3 md:w-1/2 overflow-y-auto bg-white dark:bg-zinc-900 text-black dark:text-white"
				enter="transition ease-in-out duration-300 transform"
				enterFrom="-translate-x-full"
				enterTo="translate-x-0"
				leave="transition ease-in-out duration-300 transform"
				leaveFrom="translate-x-0"
				leaveTo="-translate-x-full"
			>
				<DialogDescription>
					<div class=" h-screen flex flex-col">
						<TopNav>
							<Logo />
							<div class="flex items-center gap-3 ml-6 h-full">
								<TopNavLangLink lang="en" />
								<TopNavLangLink lang="uk" />

								<Button on:click={() => (open = !open)} type={'button'} class="ml-6">
									<span class="sr-only">Close main menu</span>
									<Icon src={XMark} theme="solid" class="h-7 w-7" aria-hidden="true" />
								</Button>
							</div>
						</TopNav>

						<div class="divide-y dark:divide-zinc-800">
							<div class="flex flex-col p-6 gap-3 w-full">
								<TopNavLink media={'mobile'} exact href={localePath('/')}
									>{$t('global.menu.gallery')}</TopNavLink
								>
								<TopNavLink media={'mobile'} href={localePath('/users')}
									>{$t('global.menu.users')}</TopNavLink
								>
							</div>

							{#if currentUser}
								<div class="flex flex-col gap-3 py-3 divide-y dark:divide-zinc-800">
									<div
										class="flex justify-between gap-3 pl-6 pr-3 min-[500px]:pr-6 items-center w-full"
									>
										<span class="font-semibold flex items-center"
											><Avatar user={currentUser} size={'w-10 h-10 '} withName /></span
										>

										<AddWorkLink />
									</div>

									<ul class=" flex flex-col">
										<MyProfileLinksGroup />
										<li>
											<LogoutButton />
										</li>
									</ul>
								</div>
							{:else}
								<div class="flex items-center py-6 justify-center gap-6">
									<AddWorkLink />
									<LoginLink />
								</div>
							{/if}

							<div />
						</div>

						<FooterContent media="mobile" />
					</div>
				</DialogDescription>
			</TransitionChild>
		</Dialog>
	</Transition>
</div>
