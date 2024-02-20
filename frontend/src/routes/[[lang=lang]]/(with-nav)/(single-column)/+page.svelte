<script lang="ts">
	import type { PageData } from './$types';
	import MetaGroups from '$lib/components/MetaGroups.svelte';
	import { CheckBadge, Rss } from '@steeze-ui/heroicons';
	import { Icon } from '@steeze-ui/svelte-icon';
	import ArticlePreview from '$lib/components/post/ArticlePreview.svelte';
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import FollowButton from '$lib/components/atoms/buttons/FollowButton.svelte';

	import { getContext } from 'svelte';
	import { localePath } from '$lib/translations';

	const t = getContext('t');
	const locale = getContext('locale');
	export let data: PageData;
</script>

<MetaGroups
	title={$t('global.seo.title.index')}
	description={$t('global.seo.description.index')}
	image="https://i.arts.center/logo_white.png"
/>

<div class="flex xl:flex-row flex-col max-xs:mx-1 xl:divide-x dark:divide-zinc-800">
	<!------- Blogs ------>
	<div class="xl:w-3/4 divide-y dark:divide-zinc-700 xl:pr-16">
		<div class="mt-9 pb-6 dark:border-zinc-800 flex items-center gap-3">
			<h2 class=" text-xl font-bold">{$t('global.main_page.featured_posts')}</h2>
			<a href={localePath($locale, '/rss/featured')}>
				<Icon src={Rss} class="w-6 h-6 stroke-amber-500 stroke-1 hover:stroke-2" />
			</a>
		</div>

		<div class=" divide-y dark:divide-zinc-800">
			{#each data.posts as post (post.id)}
				<ArticlePreview {post} withAuthor />
			{/each}
		</div>
	</div>

	<div class="xl:w-1/3 space-y-16 pt-9 xl:pl-16">
		<!------- Last verified artists ------>
		<div>
			<div class="border-b pb-6 mb-6 dark:border-zinc-800 flex items-center gap-3">
				<h2 class="  text-xl font-bold">{$t('global.main_page.last_verified')}</h2>
				<Icon src={CheckBadge} class="w-6 h-6 text-emerald-500 " />
			</div>

			<div class="space-y-6">
				{#each data.users as user (user.id)}
					<div class="flex items-center justify-between gap-3">
						<AvatarLink {user} withName size={'w-8 h-8'} />

						<div><FollowButton size={'xs'} {user} /></div>
					</div>
				{/each}
			</div>
		</div>
	</div>
</div>
