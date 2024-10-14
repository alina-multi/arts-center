<script lang="ts">
	import { handleIsMy } from '$lib/helpers/handleIsMy';
	import { fetchData } from '$lib/helpers/fetchData';
	import { user as currentUser, isUserLoading, showAuthModal } from '$lib/stores/auth';
	import { getContext } from 'svelte';
	import { localePath } from '$lib/translations';

	const t = getContext('t');
	const locale = getContext('locale');

	export let user, addStyles: string;
	let url = '/api/follow';

	let isMy = false;
	$: isMy = handleIsMy($currentUser, user.id);

	$: follows = $currentUser?.follows?.user;
	$: isFollowing = follows?.some((id) => id === Number(user.id));

	const handleFollow = () => {
		if ($currentUser) {
			if (isFollowing) {
				onUnfollow();
			} else {
				onFollow();
			}
		} else {
			showAuthModal.set(true);
		}
	};

	async function onFollow() {
		isFollowing = true;
		fetchData('POST', url, { followable_type: 'user', followable_id: Number(user.id) });
	}

	async function onUnfollow() {
		isFollowing = false;
		fetchData('DELETE', url, { followable_type: 'user', followable_id: Number(user.id) });
	}
</script>

{#if !$isUserLoading}
	{#if isMy}
		<a
			href={localePath($locale, '/my/profile')}
			class=" {addStyles} border border-zinc-600 dark:bg-zinc-800 px-3 py-1 text-center transition-all dark:hover:bg-zinc-700 dark:border-zinc-700 dark:text-white cursor-pointer"
		>
			<span>{$t('global.my_links.edit')}</span>
		</a>
	{:else}
		<button
			class=" {addStyles} border border-zinc-600 dark:bg-zinc-800 px-3 py-1 text-center transition-all dark:hover:bg-zinc-700 dark:border-zinc-700 dark:text-white cursor-pointer  {isFollowing
				? 'opacity-50'
				: ''} "
			on:click={() => handleFollow()}
		>
			<span
				>{isFollowing
					? `${$t('global.buttons.following')}`
					: `${$t('global.buttons.follow')}`}</span
			>
		</button>
	{/if}
{/if}
