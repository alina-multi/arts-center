<script lang="ts">
	import type { NewReplyNotification } from '$lib/interfaces/Notification';
	import { localePath,t } from '$lib/translations';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ArrowUturnRight } from '@steeze-ui/heroicons';

	export let notification: NewReplyNotification;
	let { username, name, text, original_text } = notification;
	let href = localePath(`/${username}`);
</script>

<a
	href={localePath(`/work/${notification?.work_id}#${notification?.comment_id}`)}
	class="flex gap-3 items-center text-sm w-full py-3"
>
	<span class="p-1.5 rounded-full bg-blue-500"
		><Icon src={ArrowUturnRight} theme="solid" class="w-5 h-5 text-white" /></span
	>
	<div class="flex flex-wrap items-center">
		<a {href} class="font-semibold mr-3 hover:underline">{name}</a>
		<span class="mr-1"> {$t(`global.notifications.replied`)}:  </span>
		<span class="mr-3 font-semibold text-sm">"{text}"</span>
		<span class=" mr-1">{$t(`global.notifications.to_your_comment`)}: </span>
		<span>"{original_text}"</span>
	</div>
</a>
