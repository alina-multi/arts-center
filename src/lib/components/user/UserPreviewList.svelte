<script lang="ts">
	import UserPreview from '$lib/components/user/UserPreview.svelte';
	import UserPreviewPremium from '$lib/components/user/UserPreviewPremium.svelte';

	export let users: Array<object>, tags, lastWorks;
</script>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-3 ">
	{#each users as user (user.id)}
		{#if user.subscribed}
			<UserPreviewPremium {...user} {tags} {lastWorks} />
		{:else}
			<UserPreview {...user} {tags} {lastWorks} />
		{/if}
	{/each}
</div>
