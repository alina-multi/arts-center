<script lang="ts">
	import { handleIsMy } from '$lib/helpers/handleIsMy';
	import AuthModal from '../AuthModal.svelte';
	import { fetchData } from '$lib/helpers/fetchData';
	import { user as currentUser, isUserLoading } from '$lib/stores/auth';
	import { getContext } from 'svelte';
	import { localePath } from '$lib/translations';

	const t = getContext('t');
	const locale = getContext('locale');

	export let user, size: string;
	let url = '/api/follow';

	let isMy = false;
	$: isMy = handleIsMy($currentUser, user.id);

	let open = false;

	// isFollowing - some problem with reactiviity

	let follows = $currentUser?.follows?.user;
	let isFollowing = follows?.some((id) => id === Number(user.id));

	const handleFollow = () => {
		if ($currentUser) {
			if (isFollowing) {
				onUnfollow();
			} else {
				onFollow();
			}
		} else {
			open = true;
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

{#if isMy}
	<a
		href={localePath($locale, '/my/profile')}
		class="  {`text-${size}`}  w-full transition-all dark:border-zinc-700 dark:hover:bg-zinc-700 dark:text-white cursor-pointer"
	>
		<span>{$t('global.my_links.edit_profile')}</span>
	</a>
{:else}
	<button
		class="  {`text-${size}`} {`text-${size}`}  {isFollowing
			? 'opacity-50'
			: ''} w-full transition-all dark:hover:bg-zinc-700 dark:border-zinc-700 dark:text-white cursor-pointer"
		on:click={() => handleFollow()}
	>
		<span
			>{isFollowing ? `${$t('global.buttons.following')}` : `${$t('global.buttons.follow')}`}</span
		>
	</button>
{/if}

{#if open}
	<AuthModal bind:open type={$t('global.not_logged_in.follow')} />
{/if}
