<script lang="ts">
	import type { PageData } from './$types';
	import MetaGroups from '$lib/components/MetaGroups.svelte';
	import { t, languageFind, localePath } from '$lib/translations';
	import { CheckBadge, ChatBubbleBottomCenterText } from '@steeze-ui/heroicons';
	import { Icon } from '@steeze-ui/svelte-icon';
	import Picture from '$lib/components/atoms/Picture.svelte';
	import Time from 'svelte-time/src/Time.svelte';
	import UserPreview from '$lib/components/user/UserPreview.svelte';

	import ImageWork from '$lib/components/atoms/ImageWork.svelte';

	export let data: PageData;
</script>

<MetaGroups title={$t('global.seo.title.index')} description={$t('global.seo.description.index')} />

<div class="grid xl:grid-cols-2 xl:gap-6 mt-6 gap-12">
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
			<h2 class="text-lg xs:text-2xl font-bold">{$t('global.main_page.discussions')}</h2>
			<Icon src={ChatBubbleBottomCenterText} class="w-7 h-7 " />
		</div>

		<div class="space-y-6 h-36">
			{#each data.comments as comment (comment.id)}
				<div class="flex gap-3 sm:gap-6 transition-all">
					<a
						href={localePath(`/work/${comment.work.id}`)}
						class="flex w-4/12 h-fit rounded-sm overflow-hidden shrink-0 hover:opacity-90"
					>
						<Picture
							photo={comment.work.preview}
							alt={'title'}
							class={'aspect-[3/12] flex object-cover w-full h-36 '}
						/>
					</a>

					<div>
						<Time
							relative
							timestamp={comment.created_at}
							class="text-zinc-500 text-xs leading-none"
						/>
						<div class="text-sm mt-1 flex flex-wrap items-center gap-1">
							<a
								href={localePath(`/${comment.owner.username} `)}
								class="font-semibold hover:underline">{comment.owner.name}</a
							>
							<span class="dark:text-zinc-300">{$t('global.main_page.comment_work')}</span>
							<a href={localePath(`/work/${comment.work.id}`)} class="font-semibold hover:underline"
								>"{languageFind(comment.work.titles)?.title}"</a
							>
						</div>

						<a
							href={localePath(`/work/${comment.work.id}#${comment.id}`)}
							class="block w-fit prose prose-sm text-sm border mt-2 border-zinc-200 p-3 rounded-md bg-zinc-50 dark:bg-zinc-900 dark:text-white dark:border-zinc-800 space-y-2"
						>
							<div class="line-clamp-2 whitespace-pre-wrap">{comment.text}</div>
						</a>
					</div>
				</div>
			{/each}
		</div>
	</div>
</div>
