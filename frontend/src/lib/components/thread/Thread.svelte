<script lang="ts">
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import { user } from '$lib/stores/auth';
	import Time from '$lib/components/thread/Time.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Trash } from '@steeze-ui/heroicons';
	import { getContext, createEventDispatcher } from 'svelte';
	import { fetchData } from '$lib/helpers/fetchData';
	import { invalidateAll } from '$app/navigation';
	import ActionModal from '$lib/components/my/ActionModal.svelte';
	import { Edit } from '@steeze-ui/material-design-icons';
	import { isEditable } from '$lib/helpers/comments';

	export let thread;

	const t = getContext('t');
	const dispatch = createEventDispatcher();

	let deleteMessageModal = false;
	$: currentMessageId = null;

	async function deleteMessage() {
		const url = `/api/thread/${thread.id}/message/${currentMessageId}`;
		const response = await fetchData('DELETE', `${url}`, {});
		if (response.ok) {
			await invalidateAll();
		}
		deleteMessageModal = false;
	}
</script>

{#each thread.messages as message (message.id)}
	<div
		id="message-{message.id}"
		class="group mb-4 flex {$user?.id === message?.user.id ? 'justify-end' : 'justify-start'}"
	>
		<div class="flex items-start gap-2.5">
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

					{#if isEditable(message.created_at)}<button
							type="button"
							on:click={() => dispatch('edit', { message })}
						>
							<Icon src={Edit} class="h-4 w-4" />
						</button>{/if}
				</div>
			{/if}

			<div>
				<div
					title={new Date(message.created_at).toUTCString()}
					class="flex flex-col w-full sm:max-w-[420px] leading-1.5 px-4 py-2 {$user?.id ===
					message?.user.id
						? 'border-zinc-200 bg-blue-600 dark:hover:bg-blue-500 text-white rounded-l-xl rounded-tr-xl'
						: ' border-zinc-200 bg-zinc-100 dark:bg-zinc-600 rounded-e-xl rounded-es-xl   '}   "
				>
					<p class="text-sm font-normal break-words whitespace-pre-wrap leading-relaxed">
						{message?.message}
					</p>
				</div>
				<div
					class="flex {$user?.id === message?.user.id
						? 'justify-end '
						: 'justify-start'}   items-centergap-3"
				>
					<div class="text-[11px] font-light text-zinc-500 mt-1">
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
