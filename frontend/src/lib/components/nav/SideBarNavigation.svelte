<script lang="ts">
	import {
		Dialog,
		DialogDescription,
		DialogOverlay,
		Transition,
		TransitionChild
	} from '@rgossiaux/svelte-headlessui';
	import { localePath } from '$lib/translations';
	import Button from '$lib/components/atoms/buttons/Button.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Bars4, XMark } from '@steeze-ui/heroicons';
	import TopNav from '$lib/components//nav/top/TopNav.svelte';
	import TopNavLangLink from './TopNavLangLink.svelte';
	import Logo from '$lib/components/atoms/Logo.svelte';
	import AddWorkButton from '$lib/components/atoms/buttons/AddWorkButton.svelte';
	import LoginLink from './LoginLink.svelte';
	import TopNavLink from './TopNavLink.svelte';
	import MyProfileLinksGroup from './MyProfileLinksGroup.svelte';
	import LogoutButton from '$lib/components/atoms/buttons/LogoutButton.svelte';
	import AvatarLink from '../atoms/AvatarLink.svelte';
	import FooterContent from '../footer/FooterContent.svelte';
	import { user } from '$lib/stores/auth';
	import { getContext } from 'svelte';

	const t = getContext('t');
	const locale = getContext('locale');

	export let open = false;
</script>

<Button on:click={() => (open = !open)} type={'button'}>
	<span class="sr-only">Open main menu</span>
	<Icon src={Bars4} class="h-9 w-9  dark:text-white" aria-hidden="true" />
</Button>

<Transition show={open} class="hidden">
	<Dialog {open} on:close={() => (open = !open)} class="relative xl:hidden ">
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
						<div class="flex items-center gap-6 ml-6 h-full">
							<TopNavLangLink lang="en" />
							<TopNavLangLink lang="uk" />

							<Button on:click={() => (open = !open)} type={'button'} class="ml-6">
								<span class="sr-only">Close main menu</span>
								<Icon src={XMark} theme="solid" class="h-7 w-7" aria-hidden="true" />
							</Button>
						</div>
					</TopNav>

					<div class="flex flex-col p-6 gap-3 w-full">
						<TopNavLink media={'mobile'} exact href={localePath($locale, '/tag/all/popular')}
							>{$t('global.menu.gallery')}</TopNavLink
						>
						<TopNavLink media={'mobile'} href={localePath($locale, '/users')}
							>{$t('global.menu.users')}</TopNavLink
						>
					</div>

					{#if $user}
						<div class="flex flex-col gap-3 pb-3">
							<div
								class="flex justify-between gap-3 pl-6 pr-3 min-[500px]:pr-6 items-center w-full border-y dark:border-zinc-800 py-3"
							>
								<AvatarLink user={$user} size={'w-12 h-12 '} withName nameStyles="font-semibold" />

								<AddWorkButton />
							</div>

							<ul class=" flex flex-col gap-2">
								<MyProfileLinksGroup />
								<li>
									<LogoutButton />
								</li>
							</ul>
						</div>
					{:else}
						<div class="flex items-center py-6 justify-center gap-6 border-y dark:border-zinc-800">
							<AddWorkButton />
							<LoginLink />
						</div>
					{/if}

					<div />

					<FooterContent media="mobile" />
				</div>
			</DialogDescription>
		</TransitionChild>
	</Dialog>
</Transition>
