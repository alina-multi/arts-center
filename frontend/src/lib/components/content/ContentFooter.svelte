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
	class="flex max-md:flex-col-reverse justify-beetwen items-stretch lg:items-start lg:mt-6 gap-6 dark:text-gray-300"
>
	<TagsGroup tags={entity.tags} media="flex w-full  md:hidden" />

	<div class="lg:w-4/6">
		<CommentBlocks
			{commentable_type}
			commentsCount={entity.comments}
			commentable_id={entity.id}
			{isMy}
		/>
	</div>
	<div class="flex flex-col lg:w-1/3 gap-6">
		{#each entity.owners as user (user.id)}
			<div
				class="flex flex-col md:max-lg:shadow border border-zinc-200 dark:border-zinc-800 dark:bg-zinc-900 rounded-sm"
			>
				<div class="px-6 py-6 bg-zinc-50 dark:bg-zinc-800"><UserPreview {user} /></div>
			</div>

			{#if user.verified_at}
				<DonateForm {user} />
			{/if}
		{/each}

		{#if !$user}
			<div><AuthStub /></div>
		{/if}
		<TagsGroup tags={entity.tags} media="hidden md:flex" />
	</div>
</div>
