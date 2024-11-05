<script lang="ts">
	import type { ActionData, PageData } from './$types';
	import Conversation from '$lib/components/chat/Conversation.svelte';
	import { enhance } from '$app/forms';
	export let data: PageData;
	export let form: ActionData;

	import TextAreaInput from '$lib/components/input/TextAreaInput.svelte';

	let newMessage = '';
</script>

<div class="flex-1 overflow-y-auto p-4 pr-0" id="thread">
	<Conversation messages={data.thread.messages} />
</div>
<div class="p-4 pr-0">
	<form method="POST" use:enhance class="flex gap-4">
		<TextAreaInput name={'message'} bind:value={newMessage} rows={1} />

		<button
			disabled={newMessage.trim() === ''}
			type="submit"
			class="bg-zinc-900 font-medium text-white px-6 py-2 hover:bg-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-2"
			class:!bg-zinc-300={newMessage.trim() === ''}
		>
			Send
		</button>
	</form>
</div>
