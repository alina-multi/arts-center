<script lang='ts'>
	import type { NewReplyNotification, NewWorkCommentNotification } from '$lib/interfaces/Notification';
	import { localePath, languageFind } from '$lib/translations';

	export let notification: NewReplyNotification;

	let { username, name, text, original_text } = notification;
	let href = localePath(`/${username}`);
	let title = languageFind(notification.work_titles)?.title;
</script>
<a {href}>{name}</a> wrote {text} in response to your comment {original_text} for {title}