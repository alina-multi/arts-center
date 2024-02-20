<script lang="ts">
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import Time from 'svelte-time';
	import EllipsisButton from '$lib/components/atoms/buttons/EllipsisButton.svelte';
	import BlockButton from '$lib/components/atoms/buttons/BlockButton.svelte';
	import ReportButton from '$lib/components/atoms/buttons/ReportButton.svelte';
	import { user } from '$lib/stores/auth';
	import ReportModal from '../atoms/ReportModal.svelte';
	import type { Comment } from '$lib/interfaces/Comment';
	import { getContext } from 'svelte';

	const t = getContext('t');

	export let comment: Comment,
		onEdit: () => void,
		deleteComment: (comment_id: string) => Promise<void>,
		parentComments: [Comment] | [],
		isMy: boolean;

	let reportModalOpen = false;
	const comment_id = comment?.id?.toString();

	function isEditable(): boolean {
		const now = new Date();
		const createdAt = new Date(comment.created_at);
		const elapsedMinutes = (now - createdAt) / (1000 * 60);
		return elapsedMinutes < 5;
	}
</script>

<div class="flex items-center justify-between pr-3">
	<div class="flex items-center gap-2">
		<div class="flex font-semibold">
			<AvatarLink user={comment.owner} withName={true} size={'w-8 h-8 '} />
		</div>
		<span class="h-1 w-1 bg-zinc-500 rounded-full" />
		<Time relative timestamp={comment.created_at} class="text-zinc-500" />

		<div
			class="flex divide-x font-semibold text-zinc-500 dark:text-zinc-400 dark:divide-zinc-800 mr-3"
		>
			{#if $user && Number($user.id) === Number(comment.owner.id)}
				{#if isEditable()}<button class="px-3" on:click={() => onEdit()}>
						{$t('global.buttons.edit')}
					</button>{/if}
				{#if !isMy}
					<button class="px-3" on:click={() => deleteComment(comment_id)}>
						{$t('global.buttons.delete')}
					</button>{/if}
			{/if}

			{#if isMy}
				<button class="px-3" on:click={() => deleteComment(comment_id)}>
					{$t('global.buttons.delete')}</button
				>
			{/if}
		</div>
	</div>
	{#if $user}
		<EllipsisButton type={'horizontal'}>
			<div slot="description" class="flex flex-col">
				<BlockButton
					user_id={Number(comment.owner.id)}
					bind:entity={parentComments}
					commentID={comment_id}
				/>
				<ReportButton bind:open={reportModalOpen} />
			</div>
		</EllipsisButton>
	{/if}
</div>

{#if reportModalOpen}
	<ReportModal
		bind:open={reportModalOpen}
		feedbackable_type="comment"
		feedbackable_id={Number(comment_id)}
	/>
{/if}
