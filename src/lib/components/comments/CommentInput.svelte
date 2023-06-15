<script lang="ts">
	import { page } from '$app/stores';
	import { onMount } from 'svelte';
	

	export let  isReply: boolean,  handleSubmit, textarea;


	let currentUser = $page.data.currentUser;

	onMount(() => {
		if (isReply) {
			textarea.focus();
		}
	});


			

</script>

<div class="flex flex-col gap-3 dark:border-gray-800 mt-6">
	<div class="flex gap-3 w-full">
		<img
			class="hidden sm:inline-block h-12 w-12 rounded-full"
			src={currentUser.avatar.src}
			alt={'Avatar of ' + currentUser.name}
		/>
		<form method="POST" class="mx-auto w-full" on:submit|preventDefault={()=> handleSubmit('POST')}>
			<textarea
				bind:this={textarea}
				placeholder="Add a comment..."
				rows='2'
				class="block w-full text-gray-900 placeholder:text-sm rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:placeholder:text-gray-300 dark:focus:border-amber-600 dark:focus:ring-amber-600 shadow-sm focus:border-amber-600 focus:ring-amber-600 border-gray-300 "
			/>

			<div class="flex flex-row-reverse mt-3">
				<button
					class=" px-6 py-1 shadow-sm border dark:border-gray-600 text-gray-500 text-sm font-semibold rounded-full hover:text-white hover:bg-sky-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-700"
					>{isReply ? 'Reply' : 'Post comment'}</button
				>
			</div>
		</form>
	</div>
	
</div>
