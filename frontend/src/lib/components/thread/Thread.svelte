<script lang="ts">
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import { user } from '$lib/stores/auth';
	import Time from '$lib/components/thread/Time.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Trash } from '@steeze-ui/heroicons';
	import { afterUpdate, getContext } from 'svelte';
	import { fetchData } from '$lib/helpers/fetchData';
	import { invalidateAll } from '$app/navigation';
	import ActionModal from '$lib/components/my/ActionModal.svelte';
	import { Edit } from '@steeze-ui/material-design-icons';
	import { isEditable } from '$lib/helpers/comments';

	export let thread, onEdit;

	const t = getContext('t');
	let deleteMessageModal = false;
	$: currentMessageId = null;

	afterUpdate(() => {
		let lastElement = thread.messages[thread.messages.length - 1];
		const el = document.getElementById(`message-${lastElement?.id}`);
		el.scrollIntoView({ behavior: 'instant', block: 'end' });
	});

	async function deleteMessage() {
		const url = `/api/thread/${thread.id}/message/${currentMessageId}`;
		const response = await fetchData('DELETE', `${url}`, {});
		if (response.ok) {
			await invalidateAll();
		}
		deleteMessageModal = false;
	}
</script>

{#each thread.messages as message, i}
	<div
		id="message-{message.id}"
		class="group mb-4 flex {$user?.id === message?.user.id ? 'justify-end' : 'justify-start'}"
	>
		<div class="flex gap-2.5">
			{#if $user?.id != message?.user.id}
				<AvatarLink user={message?.user} size="w-8 h-8 " />
			{/if}

			{#if $user?.id === message?.user.id}
				<div class="flex flex-col gap-3 invisible group-hover:visible">
					<button
						on:click={() => ((deleteMessageModal = true), (currentMessageId = message.id))}
						type="button"
						class=""
						aria-label="Delete Message"
					>
						<Icon src={Trash} class="h-4 w-4" />
					</button>

					{#if isEditable(message.created_at)}<button class="" on:click={() => onEdit(message)}>
							<Icon src={Edit} class="h-4 w-4" />
						</button>{/if}
				</div>
			{/if}

			<div>
				<div
					title={new Date(message.created_at).toUTCString()}
					class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 {$user?.id === message?.user.id
						? 'border-gray-200 bg-blue-600 text-white rounded-l-xl rounded-tr-xl'
						: ' border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl'}   dark:bg-gray-700"
				>
					<p class="text-sm font-normal pb-2.5">
						{message?.message}
					</p>
				</div>
				<div class="flex justify-end items-center gap-3">
					<div class="text-xs text-gray-500 mt-1">
						<Time date={message.created_at} />
					</div>
					<!-- {#if $user?.id === message?.user.id}
						<Icon src={Check} theme="solid" class="h-4 w-4" />
					{/if} -->
				</div>
			</div>
		</div>
	</div>
{/each}

<ActionModal bind:open={deleteMessageModal} action={deleteMessage} actionName={'Delete'}>
	{$t('my.confirmation.delete_warning')}
</ActionModal>
