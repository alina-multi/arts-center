<script lang="ts">
	import type { PageData } from './$types';
	import Picture from '$lib/components/atoms/Picture.svelte';
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import LocaleDate from '$lib/components/atoms/LocaleDate.svelte';
	import FollowButton from '$lib/components/atoms/buttons/FollowButton.svelte';
	import { getContext } from 'svelte';
	import MetaGroups from '$lib/components/MetaGroups.svelte';
	import ContentFooter from '$lib/components/content/ContentFooter.svelte';
	import RatingPreviewVote from '$lib/components/rating/RatingPreviewVote.svelte';

	const t = getContext('t');
	export let data: PageData;
</script>

<MetaGroups
	title={$t('global.seo.title.work', { name: data.post.owner.name, title: data.post.title })}
	author={data.post.owner.name}
/>

<div class="flex flex-col gap-3 mx-auto dark:lg:bg-zinc-900 py-3 md:w-5/6 xl:w-2/3 px-3 md:px-0">
	<div class="flex flex-col gap-3 dark:text-gray-400">
		<div class="flex justify-between items-center pt-1 pb-4 sm:py-6 border-b">
			<div class="flex items-center gap-3">
				<AvatarLink user={data.post.owner} withName size={'w-8 h-8'} />
				<div>
					<FollowButton size={'sm'} user={data.post.owner} />
				</div>
			</div>
			<span class="text-zinc-500 text-sm"
				>{$t('global.published_on')}
				<LocaleDate date={data.post?.published_at} />
			</span>
		</div>

		<h1 class="text-2xl py-4 sm:py-6 font-bold sm:text-4xl text-gray-00 dark:text-gray-100">
			{data.post.title}
		</h1>
	</div>
	<div class="space-y-6">
		{#each data.post.body as row}
			<div class="highlight-links">
				{#if row.type === 'text'}
					<!-- eslint-disable svelte/no-at-html-tags -->

					<div class="highlight-links text-lg">{@html row.text}</div>
				{:else if row.type === 'image'}
					<div class="flex justify-center py-3">
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

	<div class="py-9 flex justify-end">
		<RatingPreviewVote entity={data.post} votable_type={'post'} />
	</div>
</div>

<ContentFooter
	commentable_id={data.post.id}
	commentable_type="post"
	commentsCount={data.post.comments}
	comments={data.comments}
	owners={[data.post.owner]}
/>
