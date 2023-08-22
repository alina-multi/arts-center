<script lang="ts">
	import { page } from '$app/stores';
	import { onMount } from 'svelte';
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';

	export let isEditing: boolean | undefined = false,
		isReplying: boolean | undefined = false,
		onSubmit: (comment_id: string) => Promise<void>,
		commentID: string | undefined = undefined,
		value: string;
	const currentUser = $page.data.currentUser;
	commentID = commentID?.toString();
	let textarea: HTMLTextAreaElement;
	$: enabled = value.length > 3;

	onMount(() => {
		if (isReplying || isEditing) {
			textarea.focus();
		}
	});
</script>

<div class="flex flex-col gap-3 dark:border-zinc-800 mt-6">
	<div class="flex gap-3 w-full items-start">
		{#if !isEditing}
			<AvatarLink user={currentUser} size={'h-12 w-12'} />
		{/if}
		<form class="mx-auto w-full" method="POST" on:submit|preventDefault={() => onSubmit(commentID)}>
			<textarea
				bind:this={textarea}
				bind:value
				placeholder="Add a comment..."
				rows="2"
				class="block w-full text-gray-900 placeholder:text-sm rounded-md dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:placeholder:text-zinc-300 focus:ring-0 focus:border-zinc-400 dark:focus:border-zinc-500 shadow-sm border-gray-300"
			/>

			<div class="flex flex-row-reverse mt-3 gap-3">
				<button
					class="border {enabled
						? 'text-zinc-600   dark:bg-zinc-900  dark:text-zinc-200 border dark:ring-1 dark:ring-zinc-800 hover:bg-blue-600 hover:text-white hover:border-blue-600 dark:hover:bg-blue-700'
						: 'text-zinc-400 dark:bg-zinc-800 dark:text-zinc-600  '}  px-6 py-1 shadow-sm dark:border-0 text-sm font-semibold rounded-full"
				>
					{isReplying ? 'Reply' : 'Comment' && !isEditing ? 'Comment' : 'Save'}
				</button>

				<slot />
			</div>
		</form>
	</div>
</div>
