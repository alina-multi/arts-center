<script lang="ts">
	import type { Comment } from '$lib/interfaces/Comment';

	import toast from 'svelte-french-toast';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { NoSymbol } from '@steeze-ui/heroicons';
	import type { User } from '$lib/interfaces/User';
	import { fetchData } from '$lib/helpers/fetchData';
	import { getContext } from 'svelte';

	const t = getContext('t');

	export let type: 'block' | 'unblock' = 'block',
		user_id: number,
		entity: [Comment] | [User] | [],
		commentID: string | boolean = false;
	let url = '/api/blacklist';

	async function block() {
		const res = await fetchData('POST', url, { user_id });

		if (res.ok) {
			entity = entity.filter((item) => item.id.toString() !== commentID);
			toast.success('User blocked', {
				style: ' padding: 16px; color: #713200;',
				icon: '🚫'
			});
		} else {
			toast.error('Something went wrong');
		}
	}

	async function unblock() {
		const res = await fetchData('DELETE', url, { user_id });
		if (res.ok) {
			entity = entity.filter((item) => Number(item.id) !== user_id);
			toast.success('User unblocked');
		} else {
			toast.error('Something went wrong');
		}
	}
</script>

{#if type === 'block'}
	<button
		type="button"
		on:click={block}
		class="flex items-center gap-3 hover:text-red-500 px-6 py-2 hover:bg-gray-100 dark:hover:text-gray-200 dark:hover:bg-gray-600 font-semibold"
		><Icon src={NoSymbol} theme="solid" class="h-5 w-5 " aria-hidden="true" />

		<span>{$t('global.buttons.block')}</span>
	</button>
{/if}

{#if type === 'unblock'}
	<button
		type="button"
		on:click={unblock}
		class=" px-3 py-1 cursor-pointer items-center dark:bg-zinc-700 dark:border dark:border-zinc-500 text-sm flex flex-0 rounded-sm bg-zinc-400 text-white hover:bg-zinc-500 dark:hover:bg-zinc-600 font-semibold"
	>
		<span>{$t('global.buttons.unblock')}</span>
	</button>
{/if}
