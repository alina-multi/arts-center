<script lang="ts">
	import type { ActionData, PageData } from './$types';
	import Thread from '$lib/components/thread/Thread.svelte';
	import { getContext, afterUpdate } from 'svelte';
	import { ArrowLongLeft } from '@steeze-ui/heroicons';
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import { page } from '$app/stores';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { localePath } from '$lib/translations';
	import MessageForm from '$lib/components/thread/MessageForm.svelte';
	import { newMessage } from '$lib/stores/auth';
	import { fade } from 'svelte/transition';
	import { onDestroy } from 'svelte';

	const t = getContext('t');

	export let data: PageData;
	export let form: ActionData;

	let newMessages = {
		id: data.thread.id,
		messages: []
	};

	$: if ($page.params.threadID) {
		newMessages = { id: data.thread.id, messages: [] };
	}

	const unsubscribe = newMessage.subscribe((m) => {
		if (m?.thread_id === data.thread.id) {
			newMessages = {
				...newMessages,
				messages: [...newMessages.messages, m]
			};
			scrollToBottom();
		}
	});

	function scrollToBottom() {
		const el = document.getElementById(`thread-${data.thread.id}`);
		if (el) {
			el.scrollTo({ top: el.scrollHeight, behavior: 'auto' });
		}
	}

	const locale = getContext('locale');
	let href = localePath($locale, `/my/thread`);

	$: editID = null;
	$: editedValue = null;

	function onEdit(messageObj) {
		editID = messageObj.detail.message.id;
		editedValue = messageObj.detail.message.message;
	}

	afterUpdate(() => {
		scrollToBottom();
	});

	onDestroy(() => {
		unsubscribe();
	});
</script>

<div
	class=" md:border-r dark:border-r-zinc-800 {$page.params.threadID
		? 'flex-1 flex flex-col  '
		: 'hidden md:flex-1 md:flex md:flex-col'}  "
>
	<h2
		class="text-xl font-semibold py-4 md:pl-6 border-b dark:border-b-zinc-800 flex items-center gap-3"
	>
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

	<div class="flex-1 overflow-y-auto p-4 max-md:pb-12" id="thread-{data.thread.id}">
		<Thread thread={data.thread} on:edit={onEdit} />
		{#if newMessages.messages.length > 0}
			<div
				transition:fade
				class="px-4 text-center py-2 mb-4 bg-amber-50 dark:bg-zinc-800 text-amber-800 dark:text-amber-200 rounded border border-amber-200 dark:border-zinc-700 shadow-sm text-sm font-medium"
			>
				{$t('my.messages.newMessages')}
			</div>

			<div transition:fade>
				<Thread thread={newMessages} on:edit={onEdit} />
			</div>
		{/if}
	</div>
	{#key data.thread.id}
		<MessageForm bind:editID bind:editedValue threadID={data.thread.id} {form} />
	{/key}
</div>
