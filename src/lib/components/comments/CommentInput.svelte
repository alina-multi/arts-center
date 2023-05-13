<script lang="ts">
	import TextAreaInput from '$lib/components//input/TextAreaInput.svelte';

	export let user;
</script>

<div class="flex flex-col gap-3 dark:border-gray-600 dark:bg-gray-900">
	<div class="flex gap-3 w-full">
		<img
			class="hidden sm:inline-block h-10 w-10 rounded-full"
			src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
			alt=""
		/>
		<form action="#" class="flex-1">
			<TextAreaInput placeholder="Add your comment..." />
		</form>
	</div>
	<div class="flex flex-row-reverse">
		<button
			class=" px-9 py-1 shadow-sm border dark:bg-sky-00 text-gray-600 text-sm font-semibold rounded-full hover:text-white hover:bg-sky-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600"
			>Post comment</button
		>
	</div>
</div>
