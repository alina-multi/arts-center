<script lang="ts">
	import NewWorkComment from '$lib/components/notification/NewWorkComment.svelte';
	import NewWorkVote from '$lib/components/notification/NewWorkVote.svelte';
	import NewReply from '$lib/components/notification/NewReply.svelte';
	import DonationReceived from '$lib/components/notification/DonationReceived.svelte';
	import ProfileVerified from '$lib/components/notification/ProfileVerified.svelte';
	import ProfileApproved from '$lib/components/notification/ProfileApproved.svelte';
	import NewFollower from '$lib/components/notification/NewFollower.svelte';

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
		['App\\Notifications\\DonationReceived', DonationReceived],
		['App\\Notifications\\ProfileVerified', ProfileVerified],
		['App\\Notifications\\ProfileApproved', ProfileApproved],
		['App\\Notifications\\NewFollower', NewFollower]
	]);
	let component = typeToComponent.get(notification.type);
</script>

{#if component}
	<svelte:component this={component} {notification} />
{/if}
