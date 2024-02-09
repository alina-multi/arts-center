<script lang="ts">
	import type { PageData } from './$types';
	import Picture from '$lib/components/atoms/Picture.svelte';
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import LocaleDate from '$lib/components/atoms/LocaleDate.svelte';
	import FollowButton from '$lib/components/atoms/buttons/FollowButton.svelte';
	import { getContext } from 'svelte';
	import MetaGroups from '$lib/components/MetaGroups.svelte';
	import ContentFooter from '$lib/components/content/ContentFooter.svelte';

	const t = getContext('t');
	export let data: PageData;
</script>

<MetaGroups
	title={$t('global.seo.title.work', { name: data.post.user.name, title: data.post.title })}
	author={data.post.user.name}
/>

<div
	class="flex flex-col gap-3 mx-auto lg:border border-t-transparent dark:lg:bg-zinc-900 rounded-sm lg:px-28 py-3 dark:lg:border-zinc-800 dark:lg:border-t-transparent"
>
	<div class="flex flex-col gap-3 dark:text-gray-400">
		<div class="flex justify-between items-center">
			<div class="flex items-center gap-3">
				<AvatarLink user={data.post.user} withName size={'w-8 h-8'} />
				<div>
					<FollowButton size={'sm'} user={data.post.user} />
				</div>
			</div>
		</div>

		<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-1">
			<h1 class="text-xl sm:text-2xl text-gray-00 dark:text-gray-100">
				{data.post.title}
			</h1>
			<span class="text-zinc-500 text-sm"
				>{$t('global.published_on')}
				<LocaleDate date={data.post?.published_at} />
			</span>
		</div>
	</div>
	{#each data.post.body as row}
		<div class="highlight-links">
			{#if row.type === 'text'}
				<!-- eslint-disable svelte/no-at-html-tags -->
				{@html row.text}
			{:else if row.type === 'image'}
				<Picture photo={data.post.images.get(row?.image_id.toString())} />
			{/if}
		</div>
	{/each}
</div>
<ContentFooter
	commentable_id={data.post.id}
	commentable_type="post"
	commentsCount={data.post.comments}
	comments={data.comments}
	owners={[data.post.user]}
/>
