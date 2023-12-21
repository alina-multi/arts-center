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
	class="flex max-lg:flex-col justify-beetwen items-stretch lg:items-start lg:mt-6 gap-6 dark:text-gray-300"
>
	<div
		class="flex flex-col max-md:flex-col-reverse md:flex-row sm:w-full lg:flex-col lg:w-2/6 gap-6 md:max-lg:items-start"
	>
		{#each work.owners as user (user.id)}
			<div
				class="flex flex-col md:max-lg:shadow border border-zinc-200 dark:border-zinc-800 dark:bg-zinc-900 rounded-sm md:max-lg:w-5/12 md:max-lg:shrink-0"
			>
				<div class="px-6 py-6"><UserPreview {user} /></div>
			</div>

			{#if user.verified_at}
				<DonateForm {user} />
			{/if}
		{/each}

		{#if !$user}
			<div><AuthStub /></div>
		{/if}
		<TagsGroup tags={work.tags} media="hidden lg:flex" />
	</div>

	<CommentBlocks {comments} commentable_id={work.id} work_comments={work.comments} />

	<TagsGroup tags={work.tags} media="flex w-full  lg:hidden" />
</div>
