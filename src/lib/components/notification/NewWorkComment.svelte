<script lang="ts">
	import type { NewWorkCommentNotification } from '$lib/interfaces/Notification';
	import {localePath, languageFind} from '$lib/translations';

	export let notification: NewWorkCommentNotification

	let {username, name, text} = notification;
	let href = localePath(`/${username}`)
	let title = languageFind(notification.work_titles)?.title
</script>
<a {href}>{name}</a> wrote {text} for {title}