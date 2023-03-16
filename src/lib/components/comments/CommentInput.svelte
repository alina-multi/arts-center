<script lang="ts">
	import TextAreaInput from '$lib/components//input/TextAreaInput.svelte';
	export let user;
</script>

<div
	class="flex flex-col   sm:flex-row gap-3 bg-gray-50 p-3 rounded-md sm:items-start border dark:border-gray-600 dark:bg-gray-900"
>
	<img
		class="hidden sm:inline-block h-10 w-10 rounded-full"
		src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
		alt=""
	/>
	<form action="#" class="flex-1">
		<TextAreaInput placeholder="Add your comment..." />
	</form>
	<div class="max-sm:self-end">
		<button
			class=" px-6  sm:px-4 py-2  shadow-sm bg-sky-600 dark:bg-sky-700  text-gray-100 text-sm font-semibold  rounded-full hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600"
			>Post</button
		>
	</div>
</div>
