<script lang="ts">
	import { page } from '$app/stores';
	import { onMount } from 'svelte';
	

	export let isEditing: boolean | undefined = false,
		isReplying: boolean | undefined,
		onSubmit: (comment_id: string) => Promise<void>,
		commentID: string | undefined,
		value: string;
	const currentUser = $page.data.currentUser;
	commentID = commentID?.toString();
	let textarea: HTMLTextAreaElement;

	onMount(() => {
		if (isReplying || isEditing) {
			textarea.focus();
		}
	});
</script>

<div class="flex flex-col gap-3 dark:border-gray-800 mt-6">
	<div class="flex gap-3 w-full">
		{#if !isEditing}
			<img
				class="hidden sm:inline-block h-12 w-12 rounded-full"
				src={currentUser.avatar?.src}
				alt={'Avatar of ' + currentUser.name}
			/>
		{/if}
		<form
			class="mx-auto w-full"
			method="POST"
			on:submit|preventDefault={(e) => onSubmit(commentID)}
		>
			<textarea
				bind:this={textarea}
				bind:value
				placeholder="Add a comment..."
				rows="2"
				class="block w-full text-gray-900 placeholder:text-sm rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:placeholder:text-gray-300 dark:focus:border-amber-600 dark:focus:ring-amber-600 shadow-sm focus:border-amber-600 focus:ring-amber-600 border-gray-300"
			/>

			<div class="flex flex-row-reverse mt-3 gap-3">
				<button
					class=" disabled:border-gray-100 disabled:text-gray-200 px-6 py-1 shadow-sm border dark:border-gray-600 text-gray-500 text-sm font-semibold rounded-full hover:text-white hover:bg-sky-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-700"
				>
					{isReplying ? 'Reply' : 'Comment' && !isEditing ? 'Comment' : 'Save'}
				</button>

				<slot />
			</div>
		</form>
	</div>
</div>
