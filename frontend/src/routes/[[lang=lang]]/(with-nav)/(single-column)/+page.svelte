<script lang="ts">
	import type { PageData } from './$types';
	import MetaGroups from '$lib/components/MetaGroups.svelte';
	import { localePath } from '$lib/translations';
	import { ChatBubbleBottomCenterText, CheckBadge } from '@steeze-ui/heroicons';
	import { Icon } from '@steeze-ui/svelte-icon';
	import Time from 'svelte-time/src/Time.svelte';
	import UserPreview from '$lib/components/user/UserPreview.svelte';

	import ImageWork from '$lib/components/atoms/ImageWork.svelte';
	import { getContext } from 'svelte';

	const t = getContext('t');
	const locale = getContext('locale');

	export let data: PageData;
</script>

<MetaGroups
	title={$t('global.seo.title.index')}
	description={$t('global.seo.description.index')}
	image="https://i.arts.center/logo_white.png"
/>

<div class="grid grid-cols-1 xl:grid-cols-2 xl:gap-6 mt-6 gap-12">
	<!------- Last verified artists ------>
	<div>
		<div class="border-b pb-3 mb-6 dark:border-zinc-800 flex items-center gap-3">
			<h2 class="  text-lg xs:text-2xl font-bold">{$t('global.main_page.last_verified')}</h2>
			<Icon src={CheckBadge} theme="solid" class="w-7 h-7 text-emerald-500" />
		</div>

		<div class="space-y-6">
			{#each data.users as user (user.id)}
				<div
					class="flex flex-col items-center sm:flex-row sm;gap-3 shadow-sm border rounded-sm w-full dark:bg-zinc-900 dark:border-zinc-800 bg-white"
				>
					<div
						class="xl:flex-none flex items-center grow w-full sm:w-1/2 text-lg px-3 sm:max-lg:pt-3 py-3 gap-3 overflow-hidden xl:w-3/4"
					>
						<UserPreview {user} />
					</div>
					<div
						class=" sm:px-3 lg:p-0 flex justify-end sm:max-xl:w-1/2 dark:border-gray-700 gap-3 overflow-hidden w-full"
					>
						<div class="grid xl:grid-cols-1 grid-cols-3 gap-1 overflow-hidden">
							{#each user.works as work (work.id)}
								<div class="xl:odd:hidden xl:ml-3"><ImageWork {work} /></div>
							{/each}
						</div>
					</div>
				</div>
			{/each}
		</div>
	</div>

	<div>
		<!----------- Discussions ----------->

		<div class="border-b pb-3 mb-6 dark:border-zinc-800 flex items-center gap-3">
			<h2 class="text-lg xs:text-2xl font-bold">{$t('global.main_page.featured_posts')}</h2>
			<Icon src={ChatBubbleBottomCenterText} class="w-7 h-7 " />
		</div>

		<div class="space-y-6 h-36">
			{#each data.posts as post (post.id)}
				<div class="flex gap-3 sm:gap-6">
					<a
						href={localePath($locale, `/post/${post.id}`)}
						class="flex w-4/12 h-fit rounded-sm overflow-hidden shrink-0 hover:opacity-90"
					>
						<Time
							relative
							timestamp={post.published_at}
							class="text-zinc-500 text-xs leading-none"
						/>
						{post.title}
						<a
							href={localePath($locale, `/${post.owner.username} `)}
							class="font-semibold hover:underline">{post.owner.name}</a
						>
					</a>
				</div>
			{/each}
		</div>
	</div>
</div>
