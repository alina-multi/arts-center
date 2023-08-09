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
			class="w-full {`text-${size}`}  ring-1 ring-zinc-500 text-zinc-500 dark:text-zinc-100 flex items-center justify-center gap-1 rounded-full pl-2 pr-1.5 py-0.5 shadow-sm cursor-pointer hover:bg-zinc-50"
			on:click={() => handleFollow()}
		>
			<span>Following</span>
			<Icon src={CheckCircle} class="w-4 h-4  text-zinc-500" />
		</button>
	{:else}
		<button
			class="w-full {`text-${size}`} bg-blue-700 dark:bg-blue-900 dark:hover:bg-blue-700 text-white dark:text-zinc-100 hover:bg-blue-600 flex items-center justify-center gap-1 rounded-full pl-2 pr-1.5 py-1 shadow-sm cursor-pointer"
			on:click={() => handleFollow()}
		>
			<span>Follow</span>
			<Icon src={PlusCircle} class="w-4 h-4   " />
		</button>
	{/if}
{/if}
