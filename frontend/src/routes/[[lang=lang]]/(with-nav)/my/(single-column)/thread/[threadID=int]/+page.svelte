<script lang="ts">
	import type { ActionData, PageData } from './$types';
	import Thread from '$lib/components/thread/Thread.svelte';
	import { getContext } from 'svelte';
	import { ArrowLongLeft } from '@steeze-ui/heroicons';
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import { page } from '$app/stores';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { localePath } from '$lib/translations';
	import MessageForm from '$lib/components/thread/MessageForm.svelte';

	export let data: PageData;
	export let form: ActionData;



	const locale = getContext('locale');
	let href = localePath($locale, `/my/thread`);

	$: editID = null;
	$: editedValue = null;

	function onEdit(messageObj) {
		editID = messageObj.detail.message.id;
		editedValue = messageObj.detail.message.message;
	}
</script>

<h2
	class="text-xl font-semibold py-4 pl-4 md:pl-6 border-b dark:border-b-zinc-800 mb-3 flex items-center gap-3"
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

<div class="flex-1 overflow-y-auto p-4">
	<Thread thread={data.thread} on:edit={onEdit} />
</div>



{#key data.thread.id}
	<MessageForm bind:editID bind:editedValue threadID={data.thread.id} {form} />
{/key}
