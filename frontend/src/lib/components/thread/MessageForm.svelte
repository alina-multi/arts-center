<script lang="ts">
	import { enhance, applyAction } from '$app/forms';
	import TextAreaInput from '$lib/components/input/TextAreaInput.svelte';
	import { invalidateAll } from '$app/navigation';
	import { PaperAirplane, XMark, Check } from '@steeze-ui/heroicons';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { fetchData } from '$lib/helpers/fetchData';
	import { getContext } from 'svelte';

	const t = getContext('t');
	const locale = getContext('locale');

	export let editID: number | null, editedValue: string | null, threadID: number;

	let newMessage = '';
	let isSubmitting = false;

	async function editSubmit() {
		if (!editedValue?.trim()) return;

		const url = `/api/thread/${threadID}/message/${editID}`;
		const response = await fetchData('PUT', url, { message: editedValue });

		if (response.ok) {
			editID = null;
			editedValue = null;
			await invalidateAll();
		}
	}
	function isProbablyMobile() {
		return window.matchMedia('(pointer: coarse)').matches;
	}

	function handleKeydown(event: KeyboardEvent) {
		if (event.key === 'Enter') {
			if (event.shiftKey) return;

			if (isProbablyMobile()) return;

			event.preventDefault();

			const trimmed = newMessage.trim();
			if (!trimmed || isSubmitting) return;

			isSubmitting = true;

			const form = (event.target as HTMLElement)?.closest('form') as HTMLFormElement;
			if (form) form.requestSubmit();

			setTimeout(() => (isSubmitting = false), 1000);
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
			isSubmitting = false;
			applyAction(result);
		};
	}}
	class="flex gap-4 p-4 max-md:fixed max-md:bottom-0 max-md:left-0 max-md:w-full max-md:bg-white max-md:dark:bg-black"
>
	{#if editID}
		<TextAreaInput
			name="edit_message"
			bind:value={editedValue}
			rows={2}
			placeholder={$t('my.messages.editPlaceholder')}
		/>

		<button
			on:click={() => (editID = null)}
			type="button"
			class="text-zinc-500"
			aria-label={$t('my.messages.cancelEdit')}
		>
			<Icon src={XMark} class="w-8 h-8" />
		</button>

		<button
			on:click={editSubmit}
			type="button"
			class="text-amber-500"
			aria-label={$t('my.messages.confirmEdit')}
		>
			<Icon src={Check} class="w-8 h-8 stroke-2" />
		</button>
	{:else}
		<TextAreaInput
			name="message"
			bind:value={newMessage}
			rows={2}
			placeholder={$t('my.messages.newPlaceholder')}
			on:keydown={handleKeydown}
		/>

		<button
			type="submit"
			disabled={newMessage.trim() === '' || isSubmitting}
			class={`transition-colors duration-150 ease-in-out font-medium px-4 py-2 rounded text-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-2 ${
				newMessage.trim() === '' || isSubmitting
					? 'bg-zinc-300 dark:bg-zinc-800 dark:text-zinc-600 cursor-not-allowed'
					: 'bg-zinc-800 dark:bg-zinc-100 text-white dark:text-black hover:bg-blue-600'
			}`}
			aria-label={$t('my.messages.sendMessage')}
		>
			<Icon src={PaperAirplane} class="w-6 h-6" />
		</button>
	{/if}
</form>
