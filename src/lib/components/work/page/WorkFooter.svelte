<script lang="ts">
	import UserPreview from '$lib/components/user/UserPreview.svelte';
	import CommentBlocks from '$lib/components/comments/CommentBlocks.svelte';
	import { page } from '$app/stores';
	import AuthStub from '../AuthStub.svelte';
	import TagsGroup from '../TagsGroup.svelte';
	import { t } from '$lib/translations';
	import { user } from '$lib/stores/auth';

	export let work,
		comments = [];
</script>

<div
	class="flex max-lg:flex-col justify-beetwen items-stretch lg:items-start lg:mt-3 gap-3 dark:text-gray-300"
>
	<div class="flex flex-col sm:w-full lg:flex-col gap-3 lg:w-2/6">
		<TagsGroup tags={work.tags} media="hidden lg:flex" />

		{#if !$user}
			<div><AuthStub /></div>
		{/if}

		<div
			class=" hidden lg:flex flex-col border border-gray-200 dark:border-zinc-800 dark:bg-zinc-900 gap-3 p-3 rounded-sm shadow-sm md:max-lg:w-1/2"
		>
			{#each work.owners as user}
				<UserPreview {user} />
			{/each}
		</div>
	</div>

	<div class="lg:w-4/6">
		<div class="flex flex-col text-gray-800 dark:text-gray-300">
			<div class="border py-3 bg-gray-100 dark:bg-zinc-900 dark:border-zinc-800 rounded-t-sm">
				<span class="font-semibold px-3 md:px-6"
					>{$t('global.comment.comments')}: {work.comments}</span
				>
			</div>

			<CommentBlocks {comments} commentable_id={work.id} />
		</div>
	</div>

	<div class="flex flex-col gap-3 sm:flex-row lg:hidden items-start">
		<TagsGroup tags={work.tags} media="flex w-full sm:w-1/2 " />

		<div
			class=" sm:w-1/2 flex lg:hidden flex-col border border-gray-200 dark:border-zinc-800 dark:bg-zinc-900 p-3 rounded-sm shadow-sm w-full"
		>
			{#each work.owners as user}
				<UserPreview {user} />
			{/each}
		</div>
	</div>
</div>
