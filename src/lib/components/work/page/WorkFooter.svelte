<script lang="ts">
	import UserPreview from '$lib/components/user/UserPreview.svelte';
	import CommentBlocks from '$lib/components/comments/CommentBlocks.svelte';
	import AuthStub from '../AuthStub.svelte';
	import TagsGroup from '../TagsGroup.svelte';

	import { user } from '$lib/stores/auth';
	import DonateForm from '$lib/components/atoms/DonateForm.svelte';

	export let work,
		comments = [];
</script>

<div
	class="flex max-md:flex-col-reverse justify-beetwen items-stretch lg:items-start lg:mt-6 gap-6 dark:text-gray-300"
>
	<TagsGroup tags={work.tags} media="flex w-full  md:hidden" />

	<div class="lg:w-4/6">
		<CommentBlocks {comments} commentable_id={work.id} work_comments={work.comments} />
	</div>
	<div class="flex flex-col lg:w-1/3 gap-6">
		{#each work.owners as user (user.id)}
			<div
				class="flex flex-col md:max-lg:shadow border border-zinc-200 dark:border-zinc-800 dark:bg-zinc-900 rounded-sm"
			>
				<div class="px-6 py-6 bg-zinc-50"><UserPreview {user} /></div>
			</div>

			{#if user.verified_at}
				<DonateForm {user} />
			{/if}
		{/each}

		{#if !$user}
			<div><AuthStub /></div>
		{/if}
		<TagsGroup tags={work.tags} media="hidden md:flex" />
	</div>
</div>
