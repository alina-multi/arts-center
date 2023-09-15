<script lang="ts">
	import toast from 'svelte-french-toast';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { NoSymbol } from '@steeze-ui/heroicons';
	import type { User } from '$lib/interfaces/User';
	import { t } from '$lib/translations';
	import {fetchData} from '$lib/helpers/fetchData';

	export let type: 'block' | 'unblock' = 'block',
		user: User,
		parentComments: [Comment] | boolean = false,
		commentID: string | boolean = false;
	let url = '/api/blacklist';

	async function block() {
		const res = await fetchData('POST', url, { user_id: Number(user.id) });

		if (res.ok) {
			parentComments = parentComments.filter((item) => item.id.toString() !== commentID);
			toast.success('User blocked', {
				style: ' padding: 16px; color: #713200;',
				icon: '🚫'
			});
		} else {
			toast.error('Something went wrong');
		}
	}

	async function unblock() {
		const res = await fetchData('DELETE', url, { user_id: Number(user.id) });
		if (res.ok) {
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
		<span class="sr-only">{$t('global.buttons.block')}</span>
		<span>{$t('global.buttons.block')}</span>
	</button>
{/if}

{#if type === 'unblock'}
	<button
		type="button"
		on:click={unblock}
		class="hover:text-gray-900 px-3 hover:bg-gray-100 dark:hover:text-gray-200 dark:hover:bg-gray-600 font-semibold"
	>
		<span class="sr-only">{$t('global.buttons.unblock')}</span>
		<span>{$t('global.buttons.unblock')}</span>
	</button>
{/if}
