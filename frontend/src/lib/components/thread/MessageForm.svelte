<script lang="ts">
	import { enhance, applyAction } from '$app/forms';
	import TextAreaInput from '$lib/components/input/TextAreaInput.svelte';
	import { invalidateAll, goto } from '$app/navigation';

	import { PaperAirplane, XMark, Check, ArrowLongLeft } from '@steeze-ui/heroicons';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { fetchData } from '$lib/helpers/fetchData';

	export let editID: number | null, editedValue: string | null, threadID: number;

	export let data, form;
	let newMessage = '';

	async function editSubmit() {
		const url = `/api/thread/${threadID}/message/${editID}`;
		const response = await fetchData('PUT', `${url}`, { message: editedValue });

		if (response.ok) {
			editID = null;
			editedValue = null;
			await invalidateAll();
		}
	}
</script>

<form
	method="POST"
	use:enhance={() => {
		return async ({ result }) => {
			if (result.type === 'success') {
				await invalidateAll();
				newMessage = '';
			}
			applyAction(result);
		};
	}}
	class="flex gap-4 p-4"
>
	{#if editID}
		<TextAreaInput name={'edit_message'} bind:value={editedValue} rows={1} />

		<button on:click={() => (editID = null)} type="button" class=" text-zinc-500">
			<Icon src={XMark} class="w-8 h-8" />
		</button>
		<button on:click={editSubmit} type="button" class="text-amber-500">
			<Icon src={Check} class="w-8 h-8 stroke-2" />
		</button>
	{:else}
		<TextAreaInput name={'message'} bind:value={newMessage} rows={1} />
		<button
			disabled={newMessage.trim() === ''}
			type="submit"
			class=" {newMessage.trim() === ''
				? 'bg-zinc-300 dark:bg-zinc-800 dark:text-zinc-600'
				: 'bg-zinc-800 dark:text-white hover:bg-blue-600 '}   font-medium text-white px-4 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-2"
		>
			<Icon src={PaperAirplane} class="w-6 h-6" />
		</button>
	{/if}
</form>
