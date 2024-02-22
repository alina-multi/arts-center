<script lang="ts">
	import UserPreview from '$lib/components/user/UserPreview.svelte';
	import CommentBlocks from '$lib/components/comments/CommentBlocks.svelte';
	import AuthStub from '$lib/components/content/AuthStub.svelte';
	import TagsGroup from '$lib/components/content/TagsGroup.svelte';

	import { user } from '$lib/stores/auth';
	import DonateForm from '$lib/components/atoms/DonateForm.svelte';
	import type { Work } from '$lib/interfaces/Work';
	import type { Post } from '$lib/interfaces/Post';

	import { getContext } from 'svelte';
	export let commentable_type: 'work' | 'post', isMy: boolean;
	const entity: Work | Post = getContext(commentable_type);
</script>

<div
	class="flex max-lg:flex-col-reverse justify-beetwen items-stretch lg:items-start lg:mt-6 gap-6 dark:text-gray-300"
>
	{#if entity.tags}
		<TagsGroup tags={entity.tags} media="flex w-full  md:hidden" />
	{/if}
	<div class="lg:w-3/5">
		<CommentBlocks
			{commentable_type}
			commentsCount={entity.comments}
			commentable_id={entity.id}
			{isMy}
		/>
	</div>
	<div class="flex flex-col lg:w-2/5 gap-6">
		{#each entity.owners as user (user.id)}
			<div
				class="flex flex-col border-y py-6 dark:bg-zinc-900 dark:pl-3 xl:border xl:p-6 border-zinc-200 dark:border-zinc-800 xl:dark:bg-zinc-900 rounded-sm"
			>
				<UserPreview {user} />
			</div>

			{#if user.verified_at}
				<DonateForm {user} />
			{/if}
		{/each}

		{#if !$user}
			<div><AuthStub /></div>
		{/if}
		{#if entity.tags}
			<TagsGroup tags={entity.tags} media="hidden md:flex" />
		{/if}
	</div>
</div>
