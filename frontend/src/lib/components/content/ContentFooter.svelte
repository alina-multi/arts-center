<script lang="ts">
	import UserPreview from '$lib/components/user/UserPreview.svelte';
	import CommentBlocks from '$lib/components/comments/CommentBlocks.svelte';
	import TagsGroup from '$lib/components/content/TagsGroup.svelte';
	import DonateForm from '$lib/components/atoms/DonateForm.svelte';
	import type { Work } from '$lib/interfaces/Work';
	import type { Post } from '$lib/interfaces/Post';

	import { getContext } from 'svelte';
	export let commentable_type: 'work' | 'post', isMy: boolean;
	const entity: Work | Post = getContext(commentable_type);
</script>

<div class="flex xl:gap-12 max-xl:flex-col-reverse mt-6 xl:mt-12 lg:max-xl:px-28  ">
	{#if entity?.tags}
		<TagsGroup
			tags={entity.tags}
			media="flex w-full  lg:hidden border-t dark:border-zinc-800 pt-6 max-xs:px-4"
		/>
	{/if}

	<div class="xl:w-8/12 mb-12">
		<CommentBlocks
			{commentable_type}
			commentsCount={entity.comments}
			commentable_id={entity.id}
			{isMy}
		/>
	</div>

	<div class=" xl:w-4/12 flex flex-col gap-9">
		{#each entity.owners as user (user.id)}
			{#if user.verified_at}
				<DonateForm {user} />
			{/if}
			<div
				class="flex flex-col border-y dark:px-3 dark:bg-zinc-900 dark:border max-xl:px-3 py-6 dark:border-zinc-800 sm:max-xl:px-6"
			>
				<UserPreview {user} />
			</div>
		{/each}

		{#if entity.tags}
			<TagsGroup tags={entity.tags} media="hidden lg:flex " />
		{/if}
	</div>
</div>

