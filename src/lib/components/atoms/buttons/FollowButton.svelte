<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { PlusCircle, CheckCircle } from '@steeze-ui/heroicons';
	import { page } from '$app/stores';
	import { handleIsMy } from '$lib/helpers/handleIsMy';
	import AuthModal from '../AuthModal.svelte';
	import { t } from '$lib/translations';


	export let user, size: string;
	let url = '/api/follow';
	let currentUser = $page.data.currentUser;

	let isMy = handleIsMy(currentUser, user.id);

	let open = false;
	let follows = currentUser?.follows.user;
	let isFollowing = follows?.some((id) => id === Number(user.id));

	export async function fetchData(method: string,url:string, body: object) {
		const response = fetch(url, {
			method,
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify(body)
		});

		return response;
	}

	const handleFollow = () => {
		if (currentUser) {
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
		fetchData('DELETE',  url, { followable_type: 'user', followable_id: Number(user.id) });
		
	}
</script>

<AuthModal bind:open />

{#if !isMy}
	{#if isFollowing}
		<button
			class="w-full {`text-${size}`} border border-1 text-zinc-600 dark:text-zinc-300 flex items-center justify-center gap-1 rounded-full pl-2 pr-1.5 py-0.5 shadow-sm cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700 dark:border-zinc-700 dark:bg-zinc-800"
			on:click={() => handleFollow()}
		>
			<span>{$t('global.buttons.following')}</span>
			<Icon src={CheckCircle} class="w-4 h-4  dark:text-zinc-300" />
		</button>
	{:else}
		<button
			class="w-full {`text-${size}`} {user.subscribed
				? ' boder-2 border  bg-blue-700 dark:bg-blue-900 text-white border-blue-700 dark:border-blue-900  dark:hover:bg-blue-700 dark:hover:border-blue-700 hover:bg-blue-600 hover:border-blue-600 '
				: 'border ring-zinc-500 dark:bg-zinc-800 hover:bg-zinc-50 text-zinc-600 dark:border-zinc-700 dark:hover:bg-zinc-700'}  dark:text-zinc-300 flex items-center justify-center gap-1 rounded-full pl-2 pr-1.5 py-0.5 shadow-sm cursor-pointer"
			on:click={() => handleFollow()}
		>
			<span>{$t('global.buttons.follow')}</span>
			<Icon src={PlusCircle} class="w-4 h-4  dark:text-zinc-300 " />
		</button>
	{/if}
{/if}
