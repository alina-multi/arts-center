<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import LocaleDate from '$lib/components/atoms/LocaleDate.svelte';
	import { Heart, ChatBubbleOvalLeft } from '@steeze-ui/heroicons';
	import { getContext } from 'svelte';
	import { localePath } from '$lib/translations';
	import Picture from '$lib/components/atoms/Picture.svelte';
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';

	const locale = getContext('locale');

	export let post,
		withAuthor = false;
	const text_preview = post.body.find((row) => row.type === 'text');
</script>

<div class="py-6">
	{#if withAuthor}
		<div class="flex items-center gap-3 mb-4">
			<AvatarLink user={post.owner} withName size={'w-6 h-6'} />

			<div class="flex items-center gap-2 text-zinc-500 dark:text-zinc-100 text-sm">
				<div class="h-0.5 w-0.5 bg-gray-400 rounded-full" />
				<LocaleDate date={post?.published_at} />
			</div>
		</div>
	{/if}

	<a
		href={localePath($locale, `/post/${post.id}`)}
		class="flex overflow-hidden items-start justify-between gap-3 sm:gap-6 md:gap-12"
	>
		<div class="line-clamp-3 sm:line-clamp-5">
			<h3 class="text-xl font-semibold leading-6">
				{post.title}
			</h3>
			<!-- eslint-disable svelte/no-at-html-tags -->
			<p class=" mt-2 xl:mt-3 text-sm leading-6 text-gray-600 dark:text-zinc-300">
				{@html text_preview.text}
			</p>
		</div>

		{#if post.image}
			<div class="w-20 h-20 sm:w-24 sm:h-24 md:w-32 md:h-32 bg-red-50 aspect-1">
				<Picture alt={post.title} class="object-cover aspect-1" photo={post.image} />
			</div>
		{/if}
	</a>

	<div class="flex items-center justify-between mt-6">
		<div class="flex items-center gap-2 text-xs text-gray-500 dark:text-white">
			<div class="flex items-center gap-1">
				<Icon src={Heart} class="h-4 w-4 stroke-1" />
				<span>{post.rating}</span>
			</div>
			<div class="flex items-center gap-1">
				<Icon src={ChatBubbleOvalLeft} class="h-4 w-4 stroke-1" />
				<span>{post.comments}</span>
			</div>
		</div>

		<!-- <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-white">
		<Icon src={Bookmark} class="xl:h-5 xl:w-5 w-6 h-6  " />
		<Icon src={EllipsisHorizontalCircle} class="w-6 h-6 xl:h-5 xl:w-5" />
	</div> -->
	</div>
</div>
