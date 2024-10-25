<script lang="ts">
	import UserPreview from '$lib/components/user/UserPreview.svelte';
	import CommentBlocks from '$lib/components/comments/CommentBlocks.svelte';
	import TagsGroup from '$lib/components/content/TagsGroup.svelte';
	import DonateForm from '$lib/components/atoms/DonateForm.svelte';
	import type { Work } from '$lib/interfaces/Work';
	import type { Post } from '$lib/interfaces/Post';
	import FollowButton from '$lib/components/atoms/buttons/FollowButton.svelte';
	import GetInTouchButton from '$lib/components/atoms/buttons/GetInTouchButton.svelte';

	import { getContext } from 'svelte';
	export let commentable_type: 'work' | 'post', isMy: boolean;
	const entity: Work | Post = getContext(commentable_type);
</script>

<div class="flex xl:gap-12 max-xl:flex-col-reverse mt-6 dark:xl:px-9">
	{#if entity?.tags}
		<TagsGroup
			tags={entity.tags}
			media="flex w-full  lg:hidden border-t dark:border-zinc-800 pt-6 max-xs:px-4"
		/>
	{/if}

	<div class="xl:w-7/12 mb-12">
		<CommentBlocks
			{commentable_type}
			commentsCount={entity.comments}
			commentable_id={entity.id}
			{isMy}
		/>
	</div>

	<div class=" xl:w-5/12 flex flex-col gap-9">
		{#each entity.owners as user (user.id)}
			{#if user.verified_at}
				<DonateForm {user} />
			{/if}

			<div
				class="space-y-6 md:max-xl:space-y-0 dark:bg-zinc-900 dark:border bg-zinc-100 shadow p-6 xl:p-9 dark:border-zinc-800 md:max-xl:flex"
			>
				<UserPreview {user} followButton={false} />
				<div class="space-y-6 md:max-xl:flex md:max-xl:items-center gap-6 md:max-xl:space-y-0">
					<div class="h-11">
						<FollowButton
							{user}
							addStyles={' block bg-zinc-800 text-white   py-2 w-full font-semibold border-zinc-800  '}
						/>
					</div>

					<GetInTouchButton {user} origin={{ type: commentable_type, ...entity }} />
				</div>
			</div>
		{/each}

		{#if entity.tags}
			<TagsGroup tags={entity.tags} media="hidden lg:flex " />
		{/if}
	</div>
</div>
