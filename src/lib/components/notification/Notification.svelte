<script lang='ts'>
	import NewWorkComment from '$lib/components/notification/NewWorkComment.svelte';
	import NewWorkVote from '$lib/components/notification/NewWorkVote.svelte';
	import NewReply from '$lib/components/notification/NewReply.svelte';

	export let notification;

	// Dirty workaround for now, until there is a new release for svelte-french-toast
	export let toast;
	if (!notification) {
		notification = toast.notification;
	}

	const typeToComponent = new Map([
		['App\\Notifications\\NewWorkComment', NewWorkComment],
		['App\\Notifications\\NewWorkVote', NewWorkVote],
		['App\\Notifications\\NewReply', NewReply],
	]);
	let component = typeToComponent.get(notification.type);
</script>

<svelte:component this={component} {notification}  />