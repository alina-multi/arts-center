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
	import { Icon } from '@steeze-ui/svelte-icon';
	import { PencilSquare, Trash } from '@steeze-ui/heroicons';
	import { isEditable } from '$lib/helpers/comments';

	const t = getContext('t');

	export let comment: Comment,
		onEdit: () => void,
		deleteComment: (comment_id: string) => Promise<void>,
		parentComments: [Comment] | [],
		isMy: boolean;

	let reportModalOpen = false;
	const comment_id = comment?.id?.toString();
</script>

<div class="flex items-center justify-between pr-3 mb-2">
	<div class="flex items-center gap-2">
		<div class="flex font-semibold">
			<AvatarLink user={comment.owner} withName={true} size={'w-8 h-8 '} />
		</div>
		<span class="h-1 w-1 bg-zinc-500 rounded-full" />
		<Time relative timestamp={comment.created_at} class="text-zinc-500 text-xs" />

		<div
			class="flex divide-x font-semibold text-zinc-500 dark:text-zinc-400 dark:divide-zinc-800 mr-3 text-xs"
		>
			{#if $user && Number($user.id) === Number(comment.owner.id)}
				{#if isEditable(comment.created_at)}<button class="px-3" on:click={() => onEdit()}>
						<Icon src={PencilSquare} class="w-4 h-4 " />
					</button>{/if}
				{#if !isMy}
					<button class="px-3" on:click={() => deleteComment(comment_id)}>
						<Icon src={Trash} class="w-4 h-4 " />
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
