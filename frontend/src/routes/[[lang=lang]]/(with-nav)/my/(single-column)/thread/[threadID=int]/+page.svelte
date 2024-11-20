<script lang="ts">
	import type { ActionData, PageData } from './$types';
	import Thread from '$lib/components/thread/Thread.svelte';
	import { enhance } from '$app/forms';
	import TextAreaInput from '$lib/components/input/TextAreaInput.svelte';
	export let data: PageData;
	export let form: ActionData;
	import { invalidateAll, goto } from '$app/navigation';
	import { getContext } from 'svelte';
	import { PaperAirplane, XMark, Check, ArrowLongLeft } from '@steeze-ui/heroicons';
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import { page } from '$app/stores';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { fetchData } from '$lib/helpers/fetchData';
	import { localePath } from '$lib/translations';


	const locale = getContext('locale');
	let href = localePath($locale, `/my/thread`);

	let editID = null;
	let newMessage = '';
	let editedMessage = null;

	function onEdit(messageObj) {
		editID = messageObj.id;
		editedMessage = messageObj.message;
	}

	async function editSubmit() {
		const url = `/api/thread/${data.thread.id}/message/${editID}`;
		const response = await fetchData('PUT', `${url}`, { message: editedMessage });

		if (response.ok) {
			editID = null;
			editedMessage = null;
			await invalidateAll();
		}
	}
</script>

<h2 class="text-xl font-semibold py-4 pl-4 md:pl-6 border-b mb-3 flex items-center gap-3">
	<a {href} class={$page.params.threadID ? 'block md:hidden' : 'block'}>
		<Icon src={ArrowLongLeft} class="w-8 h-8 stroke-1" /></a
	>

	<AvatarLink
		user={data.thread.participants[0].user}
		withName
		nameStyles="text-base"
		size="h-9 w-9"
	/>
</h2>

<div class="flex-1 overflow-y-auto p-4">
	<Thread thread={data.thread} {onEdit} />
</div>
<div class="p-4">
	<form method="POST" use:enhance class="flex gap-4">
		{#if editID}
			<TextAreaInput name={'edit_message'} bind:value={editedMessage} rows={1} />
			<button on:click={() => (editID = null)} type="submit" class=" text-zinc-500">
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
				class="bg-zinc-900 font-medium text-white px-4 py-2 hover:bg-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-2"
				class:!bg-zinc-300={newMessage.trim() === ''}
			>
				<Icon src={PaperAirplane} class="w- h-6" />
			</button>
		{/if}
	</form>
</div>
