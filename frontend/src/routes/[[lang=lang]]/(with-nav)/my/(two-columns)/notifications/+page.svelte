<script lang="ts">
	import HeaderLayout from '$lib/components/my/HeaderLayout.svelte';
	import Notification from '$lib/components/notification/Notification.svelte';
	import { Check, Cog6Tooth } from '@steeze-ui/heroicons';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { fetchData } from '$lib/helpers/fetchData.js';
	import { user } from '$lib/stores/auth.js';
	import { invalidateAll } from '$app/navigation';
	import type { UserMe } from '$lib/interfaces/User.js';
	import { getContext } from 'svelte';
	import { localePath } from '$lib/translations';

	const t = getContext('t');
	const locale = getContext('locale');

	export let data;
	async function markAllAsRead() {
		const fetch = fetchData(
			'POST',
			'/api/notifications/mark-all-read',

			unread_notifications
		);
		const response = await fetch;

		if (response.ok) {
			user.update((u: UserMe) => ({
				...u,
				unread: 0
			}));

			invalidateAll();
		}
	}

	$: unread_notifications = data.notifications.filter((n) => n.read_at === null);
	let viewed_notifications = data.notifications.filter((n) => n.read_at);
</script>

<div>
	<HeaderLayout title={$t('my.notifications.notifications')}>
		<div slot="details" class="flex items-center gap-1">
			<span> {unread_notifications.length} </span>
			<span class="hidden xs:block"> {$t('my.notifications.unread')}</span>
		</div>

		<div slot="buttons" class="flex items-center gap-4">
			<button
				on:click={markAllAsRead}
				class="flex items-center gap-3 group hover:underline pl-3 transition-all"
			>
				<span class="max-xs:text-xs max-xs:text-end text-sm"
					>{$t(`global.notifications.mark_all_as_read`)}
				</span>
				<span class="border border-black dark:border-white rounded-sm active:border-green-500 p-0.5"
					><Icon src={Check} class="w-4 h-4  active:text-green-500" /></span
				>
			</button>

			<a href={localePath($locale, `/my/notifications/preferences`)}>
				<Icon src={Cog6Tooth} class="w-7 h-7 stroke-1" />
			</a>
		</div>
	</HeaderLayout>

	{#if data.notifications?.length > 0}
		{#if unread_notifications.length > 0}
			<ul class="divide-y dark:divide-zinc-800 border-b dark:border-zinc-800 mb-6">
				{#each unread_notifications as notification (notification.id)}
		
					<li
						class="flex justify-between items-center gap-x-6 px-3 sm:px-6 bg-gray-50 dark:bg-zinc-900 hover:shadow-lg hover:bg-white transition-all dark:hover:bg-zinc-800"
					>
						<Notification {notification} />
						<div class="h-2 w-2 rounded-full bg-amber-500" />
					</li>
				{/each}
			</ul>
		{/if}

		{#if viewed_notifications.length > 0}
			<div class="px-3 sm:px-6 py-3 font-semibold">
				{$t('my.notifications.viewed')}
				</div>
			<ul class="divide-y dark:divide-zinc-800 border-y dark:border-zinc-900">
				{#each viewed_notifications as notification (notification.id)}
					<li
						class="flex justify-between items-center gap-x-6 hover:opacity-100 opacity-70 transition-all px-3 sm:px-6"
					>
						<Notification {notification} />
					</li>
				{/each}
			</ul>
		{/if}
	{:else}
		<p class="px-6 py-3">{$t('my.notifications.no_notifications')}</p>
	{/if}
</div>
