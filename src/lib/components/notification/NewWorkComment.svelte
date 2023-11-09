<script lang="ts">
	import type { NewWorkCommentNotification } from '$lib/interfaces/Notification';
	import { localePath, languageFind, t } from '$lib/translations';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChatBubbleBottomCenterText } from '@steeze-ui/heroicons';

	export let notification: NewWorkCommentNotification;

	let { username, name, text } = notification;
	let href = localePath(`/${username}`);
	let title = languageFind(notification.work_titles)?.title;
</script>

<a
	href={localePath(`/work/${notification?.work_id}#${notification?.comment_id}`)}
	class="flex gap-3 items-center w-full py-3 text-sm"
>
	<span class="p-1.5 rounded-full bg-emerald-500"
		><Icon src={ChatBubbleBottomCenterText} theme="solid" class="w-5 h-5 text-white" /></span
	>
	<div class="flex flex-wrap items-center">
		<a {href} class="font-semibold mr-3 hover:underline">{name}</a>
		<span class=" mr-1"> {$t(`global.notifications.commented`)}: </span>
		<span class="mr-3 font-semibold">"{text}"</span>
		<span class=" mr-3">{$t(`global.notifications.on_your_work`)}</span>
		<span>"{title}"</span>
	</div>
</a>
