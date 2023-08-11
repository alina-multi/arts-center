<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { PlusCircle, CheckCircle } from '@steeze-ui/heroicons';
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

	const handleFollow = () => {
		if (currentUser) {
			isFollowing = !isFollowing;
		} else {
			open = true;
		}
	};
</script>

<ModalWindow bind:open>
	<p class="text-gray-700 dark:text-gray-300 text-center text-lg border-b pb-3 font-semibold">
		You need to login to follow
	</p>
	<div class="flex gap-3 justify-center items-center py-3">
		<TopNavLink href={localePath('/login?redirect=' + $page.url.pathname)}
			>{$t('global.menu.login')}</TopNavLink
		>

		<span>or</span>
		<TopNavLink href={localePath('/register')}>{$t('global.menu.register')}</TopNavLink>
	</div>
</ModalWindow>

{#if !isMy}
	{#if isFollowing}
		<button
			class="w-full {`text-${size}`} border border-1 text-zinc-600 dark:text-zinc-300 flex items-center justify-center gap-1 rounded-full pl-2 pr-1.5 py-0.5 shadow-sm cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700 dark:border-zinc-700 dark:bg-zinc-800"
			on:click={() => handleFollow()}
		>
			<span>Following</span>
			<Icon src={CheckCircle} class="w-4 h-4  dark:text-zinc-300" />
		</button>
	{:else}
		<button
			class="w-full {`text-${size}`} {user.subscribed
				? ' boder-2 border  bg-blue-700 dark:bg-blue-900 text-white border-blue-700 dark:border-blue-900  dark:hover:bg-blue-700 dark:hover:border-blue-700 hover:bg-blue-600 hover:border-blue-600 '
				: 'border ring-zinc-500 dark:bg-zinc-800 hover:bg-zinc-50 text-zinc-600 dark:border-zinc-700 dark:hover:bg-zinc-700'}  dark:text-zinc-300 flex items-center justify-center gap-1 rounded-full pl-2 pr-1.5 py-0.5 shadow-sm cursor-pointer"
			on:click={() => handleFollow()}
		>
			<span>Follow</span>
			<Icon src={PlusCircle} class="w-4 h-4  dark:text-zinc-300 " />
		</button>
	{/if}
{/if}
