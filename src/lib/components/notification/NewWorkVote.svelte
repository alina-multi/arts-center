<script lang="ts">
	import type { NewWorkCommentNotification } from '$lib/interfaces/Notification';
	import { localePath, languageFind, t } from '$lib/translations';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Heart } from '@steeze-ui/heroicons';

	export let notification: NewWorkCommentNotification;

	let { username, name } = notification;
	let href = localePath(`/${username}`);
	let title = languageFind(notification.work_titles)?.title;
</script>

<a
	href={localePath(`/work/${notification?.work_id}`)}
	class="flex gap-3 items-center w-full py-3 text-sm"
>
	<span class="p-1.5 rounded-full bg-rose-500"
		><Icon src={Heart} theme="solid" class="w-5 h-5 text-white" /></span
	>
	<div class="flex flex-wrap items-center">
		<a {href} class="font-semibold mr-3 hover:underline">{name}</a>
		<span class="mr-1"> {$t(`global.notifications.liked`)} </span>

		<span class=" mr-3">{$t(`global.notifications.your_work`)}</span>
		<span class="font-semibold t">"{title}"</span>
	</div>
</a>
