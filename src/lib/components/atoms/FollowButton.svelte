<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { PlusCircle, MinusCircle, CheckCircle, PencilSquare } from '@steeze-ui/heroicons';
	import ModalWindow from '$lib/components/ModalWindow.svelte';
	import TopNavLink from '$lib/components//nav/TopNavLink.svelte';
	import { page } from '$app/stores';
	import { localePath, t } from '$lib/translations';
	import { handleIsMy } from '$lib/helpers/handleIsMy';

	export let user, size;
	let currentUser = $page.data.currentUser;

	let isFollowing = false;
	let isMy = handleIsMy(currentUser, user.id);

	let open = false;

	const handleFollow = (currentUser) => {
		if (currentUser) {
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
		href="{`/user/${currentUser?.id}/edit`} "
		class=" w-full flex {`text-${size}`}  items-center justify-center rounded-full px-2 py-0.5  border border-gray-500 gap-1 text-zinc-800 shadow-sm cursor-pointer dark:text-zinc-100 dark:bg-zinc-800"
	>
		<span>Edit </span>
		<Icon src={PencilSquare} class="w-4 h-4  text-zinc-500 mb-0.5 dark:text-zinc-100" />
	</a>
{:else if isFollowing}
	<button
		class="w-full {`text-${size}`} group/unfollow rounded-full pl-2 pr-1 py-0.5 border dark:text-zinc-400 dark:bg-zinc-800 dark:border-zinc-700 border-zinc-500 gap-1 text-gray-800 shadow-sm cursor-pointer "
		on:click={() => handleFollow(currentUser)}
	>
		<div class="group-hover/unfollow:hidden flex items-center justify-center gap-1">
			<span>Following</span>
			<Icon src={CheckCircle} class="w-4 h-4  text-zinc-500" />
		</div>
		<div class="group-hover/unfollow:flex hidden justify-center items-center gap-1">
			<span>Unfollow</span>
			<Icon src={MinusCircle} class="w-4 h-4  text-zinc-500" />
		</div>
	</button>
{:else}
	<button
		class="w-full {`text-${size}`} bg-sky-700 dark:bg-sky-900 dark:hover:bg-sky-700 text-white dark:text-zinc-100 hover:bg-sky-600 flex items-center justify-center gap-1 rounded-full pl-2 pr-1.5 py-1 shadow-sm cursor-pointer"
		on:click={() => handleFollow(currentUser)}
	>
		<span>Follow</span>
		<Icon src={PlusCircle} class="w-4 h-4   " />
	</button>
{/if}
