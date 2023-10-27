<script lang="ts">
	import UserPreview from '$lib/components/user/UserPreview.svelte';
	import CommentBlocks from '$lib/components/comments/CommentBlocks.svelte';
	import AuthStub from '../AuthStub.svelte';
	import TagsGroup from '../TagsGroup.svelte';
	import { t } from '$lib/translations';
	import { user } from '$lib/stores/auth';
	import DonateForm from '$lib/components/atoms/DonateForm.svelte';
	import { languageFind } from '$lib/translations';

	export let work,
		comments = [];
</script>

<div
	class="flex max-lg:flex-col justify-beetwen items-stretch lg:items-start lg:mt-6 gap-6 dark:text-gray-300"
>
	<div class="flex flex-col sm:w-full lg:flex-col gap-6 lg:w-2/6">
		{#each work.owners as user}
			<div
				class="hidden lg:flex flex-col border border-zinc-200 dark:border-zinc-800 dark:bg-zinc-900 rounded-sm shadow-sm md:max-lg:w-1/2"
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

	<div class="lg:w-4/6">
		<div class="flex flex-col text-black dark:text-gray-300">
			<div class="border py-3 bg-zinc-50 dark:bg-zinc-900 dark:border-zinc-800 rounded-t-sm">
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
