<script lang='ts'>
	import HeaderLayout from '$lib/components/my/HeaderLayout.svelte';
	import { t } from '$lib/translations';
	import Notification from '$lib/components/notification/Notification.svelte';

	export let data;
</script>


<div>
	<HeaderLayout title={$t('my.notifications')}>
		<span slot='details'> {data.notifications.length} {$t('my.unread')} </span>
	</HeaderLayout>

	<div
		class='flex flex-col border-x  border-b py-3 dark:border--ttransparent rounded-b-sm  dark:border-zinc-800 dark:bg-zinc-900'
	>
		{#if data.notifications?.length > 0}
			<ul class='lg:divide-y dark:lg:divide-zinc-800'>
				{#each data.notifications as notification (notification.id)}
					<li class='flex justify-between items-center gap-x-6 py-3 px-3 sm:px-9'>
						<Notification {notification} />
					</li>
				{/each}
			</ul>
		{:else}
			<p class='px-6 py-3 '>{$t('my.no_notifications')}</p>
		{/if}
	</div>
</div>
