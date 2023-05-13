<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { PlusCircle, MinusCircle, CheckCircle } from '@steeze-ui/heroicons';
	import ModalWindow from '$lib/components/ModalWindow.svelte';
	import TopNavLink from '$lib/components//nav/TopNavLink.svelte';
	import { page } from '$app/stores';
	import { localePath, t } from '$lib/translations';
	import { handleIsMy } from '$lib/helpers/handleIsMy';

	export let user, size;
	let userAuth = $page.data.user;

	let isFollowing = false;
	let isMy = handleIsMy(userAuth, user.id);

	let open = false;

	const handleFollow = (userAuth) => {
		if (userAuth) {
			isFollowing = !isFollowing;
		} else {
			open = true;
		}
	};
</script>

<ModalWindow bind:open>
	<p class="text-gray-700 dark:text-gray-300 text-center">You need to login to follow</p>
	<div class="flex gap-3 justify-center items-center">
		<TopNavLink href={localePath('/login?redirect=' + $page.url.pathname)}
			>{$t('global.menu.login')}</TopNavLink
		>

		<span>or</span>
		<TopNavLink href={localePath('/register')}>{$t('global.menu.register')}</TopNavLink>
	</div>
</ModalWindow>

{#if isMy}
	<a
		href="{`/user/${userAuth?.id}/edit`} "
		class="flex text-xs items-center justify-center rounded-full px-3 py-1 border border-gray-500 gap-1 text-gray-800 shadow-sm cursor-pointer"
	>
		Edit Profile
	</a>
{:else if isFollowing}
	<button
		class="{`text-${size}`} group/unfollow rounded-full px-3 py-1 border border-gray-500 gap-1 text-gray-800 shadow-sm cursor-pointer"
		on:click={() => handleFollow(userAuth)}
	>
		<div class="group-hover/unfollow:hidden flex items-center justify-center gap-1">
			<span>Following</span>
			<Icon src={CheckCircle} class="w-4 h-4  text-emerald-700" />
		</div>
		<div class="group-hover/unfollow:flex hidden justify-center items-center gap-1">
			<span>Unfollow</span>
			<Icon src={MinusCircle} class="w-4 h-4  text-emerald-700" />
		</div>
	</button>
{:else}
	<button
		class="{`text-${size}`} bg-sky-700 text-white hover:bg-sky-600 flex items-center justify-center gap-1 rounded-full px-3 py-1 shadow-sm cursor-pointer"
		on:click={() => handleFollow(userAuth)}
	>
		<span>Follow</span>
		<Icon src={PlusCircle} class="w-4 h-4   " />
	</button>
{/if}
