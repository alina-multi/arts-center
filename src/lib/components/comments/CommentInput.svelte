<script lang="ts">
	import { page } from '$app/stores';
	import { data } from '$lib/stores/comment';
	import { onMount } from 'svelte';

	export let user, isReply, onSubmit;
	let textarea;

	onMount(() => {
		if (isReply) {
			textarea.value = $data.replyHandle;
			textarea.focus();
		}
	});
</script>

<div class="flex flex-col gap-3 dark:border-gray-800 mt-6">
	<div class="flex gap-3 w-full">
		<img
			class="hidden sm:inline-block h-12 w-12 rounded-full"
			src={$page.data.currentUser.avatar.src}
			alt={'Avatar of ' + $page.data.currentUser.name}
		/>
		<form action="#" class="mx-auto w-full">
			<textarea
				bind:this={textarea}
				placeholder="Add a comment..."
				rows={isReply ? 2 : 4}
				class="block w-full text-gray-900 placeholder:text-sm rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:placeholder:text-gray-300 dark:focus:border-sky-700 dark:focus:ring-sky-700 shadow-sm focus:border-sky-600/50 focus:ring-sky-600/50 border-gray-300 focus:border-indigo-300 focus:ring-indigo-200"
			/>
		</form>
	</div>
	<div class="flex flex-row-reverse">
		<button
			class=" px-6 py-1 shadow-sm border dark:border-gray-600 text-gray-500 text-xs font-semibold rounded-full hover:text-white hover:bg-sky-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-700"
			>{isReply ? 'Reply' : 'Post'}</button
		>
	</div>
</div>
