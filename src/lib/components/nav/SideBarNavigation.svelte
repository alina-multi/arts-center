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
	import { Bars4, XMark } from '@steeze-ui/heroicons';
	import TopNav from './TopNav.svelte';
	import TopNavLangLink from './TopNavLangLink.svelte';
	import Logo from '../atoms/Logo.svelte';
	import { page } from '$app/stores';
	import Avatar from '../atoms/Avatar.svelte';

	export let user;
	export let open = false;
</script>

    <Button on:open={() => (open = !open)} type={'button'} >
        <span class="sr-only">Open main menu</span>
        <Icon src={Bars4} theme="solid" class="h-8 w-8 text-black" aria-hidden="true" />
    </Button>


<Dialog {open} on:close={() => (open = !open)} class="relative">
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
		<DialogOverlay class="fixed inset-0 " />

		<div
			class="absolute inset-y-0 right-0 w-full overflow-y-auto bg-white dark:bg-gray-900 sm:ring-1 sm:ring-gray-900/10"
		>
			<DialogDescription>
				<TopNav>
					<Logo />
					<div class="flex items-center gap-3 ml-6">
						<TopNavLangLink lang="en" />
						<TopNavLangLink lang="uk" />

						<Button on:close={() => (open = !open)} type={'button'} customClass="ml-6">
							<span class="sr-only">Close main menu</span>
							<Icon src={XMark} theme="solid" class="h-7 w-7" aria-hidden="true" />
						</Button>
					</div>
				</TopNav>

				<div class="divide-y">
					<div class="flex flex-col p-6 gap-6 w-full">
						<a href="/" class="text-lg">GALLERY</a>
						<a href="/users" class="text-lg">ARTISTS</a>
					</div>

					{#if user}
						<div class="flex flex-col gap-3 py-3 divide-y">
							<div class="pl-6"><Avatar {user} size={'w-10 h-10'} withName /></div>
							<div class=" flex flex-col pl-16 px-3 gap-6 py-3">
								<a href="/profile"> Add Work </a>

								<a href={localePath('/my/profile')}>Edit profile</a>
								<a
									href={localePath('/logout?redirect=' + $page.url.pathname)}
									data-sveltekit-preload-data="tap"
									data-sveltekit-reload>Log Out</a
								>
							</div>
						</div>
					{:else}
						<div class="flex items-center py-6 justify-center gap-6">
							<a
								href="/login?redirect={$page.url.pathname}"
								class="inline-flex border border-amber-600 rounded-full px-6 py-1 bg-amber-600 text-white shadow-sm"
								>LOG IN</a
							>

							<a
								href="/register"
								class="inline-flex border rounded-full px-3 py-1 border-black text-black shadow-sm"
								>SIGN UP</a
							>
						</div>
					{/if}

					<div />
				</div>
			</DialogDescription>
		</div>
	</Transition>
</Dialog>


