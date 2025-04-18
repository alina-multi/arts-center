<script lang="ts">
	import type { PageData } from './$types';
	import Picture from '$lib/components/atoms/Picture.svelte';
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import LocaleDate from '$lib/components/atoms/LocaleDate.svelte';
	import FollowButton from '$lib/components/atoms/buttons/FollowButton.svelte';
	import { getContext } from 'svelte';
	import MetaGroups from '$lib/components/MetaGroups.svelte';

	import RatingPreviewVote from '$lib/components/rating/RatingPreviewVote.svelte';
	import { setContext } from 'svelte';
	import { handleIsMy } from '$lib/helpers/handleIsMy';
	import { user } from '$lib/stores/auth';
	import CommentBlocks from '$lib/components/comments/CommentBlocks.svelte';
	import ShareButton from '$lib/components/atoms/buttons/ShareButton.svelte';

	const t = getContext('t');
	export let data: PageData;
	const currentDate = new Date().toDateString();
	setContext('post', { ...data.post, owners: [data.post.owner] });
	setContext('comments', data.comments);

	$: isMy = handleIsMy($user, data.post.owner.id);
</script>

<MetaGroups
	title={$t('global.seo.title.post', { name: data.post.owner.name, title: data.post.title })}
	author={data.post.owner.name}
	image={data.post?.image?.original.src}
/>
<div class="container pb-12 mx-auto">
	<div class="flex flex-col gap-3 mx-auto pt-3 xl:w-2/3 px-3 md:px-0">
		<div class="flex flex-col gap-3">
			<div
				class="flex justify-between items-center pt-1 pb-4 sm:py-6 border-b dark:border-zinc-800"
			>
				<div class="flex items-center gap-3 text-sm font-medium">
					<AvatarLink user={data.post.owner} withName size={'w-8 h-8'} />
					<div>
						<FollowButton addStyles={'text-xs w-min'} user={data.post.owner} />
					</div>
				</div>
				{#if currentDate === data.post.published_at.toDateString()}
					<div class="text-zinc-500 dark:text-zinc-100 text-sm">
						<span class="hidden xs:inline"> {$t('global.published_on')} </span>
						<LocaleDate date={data.post?.published_at} />
					</div>
				{:else}
					<div class="text-zinc-500 dark:text-zinc-100 text-xs">
						<span class="hidden xs:inline">{$t('global.updated')}</span>

						<LocaleDate date={data.post?.updated_at} />
					</div>
				{/if}
			</div>

			<h1
				class="text-2xl py-4 sm:py-6 font-semibold sm:text-3xl text-gray-00 dark:text-gray-100 tracking-wide"
			>
				{data.post.title}
			</h1>
		</div>
		<div class="space-y-6">
			{#each data.post?.body || [] as row, index}
				{@const tabindex = index + 1}
				<div>
					{#if row.type === 'text'}
						<!-- eslint-disable svelte/no-at-html-tags -->

						<a id={`p${tabindex}`} class="highlight-links text-lg">{@html row.text}</a>
					{:else if row.type === 'image'}
						<div class="flex justify-center">
							<Picture
								alt={data.post.title}
								class="w-full"
								photo={data.post.images.get(row?.image_id.toString())}
							/>
						</div>
					{/if}
				</div>
			{/each}
		</div>

		<div
			class="w-full flex justify-between gap-2 sm:gap-4 border-t  dark:border-zinc-800 pt-6 mt-9"
		>
			<RatingPreviewVote showVotedPreview entity={data.post} votable_type={'post'} />
			<div class="sm:hidden"><ShareButton /></div>
		</div>
	</div>
	<div class="mt-16 w-full">
		<CommentBlocks
			commentable_type="post"
			commentsCount={data.post.comments}
			commentable_id={data.post.id}
			{isMy}
		/>
	</div>
</div>
