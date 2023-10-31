<script lang='ts'>
	import type { PageData } from './$types';
	import MetaGroups from '$lib/components/MetaGroups.svelte';
	import { t } from '$lib/translations';
	import UserPreviewWithWorks from '$lib/components/user/UserPreviewWithWorks.svelte';
	import WorkPreview from '$lib/components/work/WorkPreview.svelte';

	export let data: PageData;
</script>
<MetaGroups title={$t('global.seo.title.index')} description={$t('global.seo.description.index')} />

<div class='grid lg:grid-cols-2 gap-6 mt-6'>
	<div>
		<h2 class='text-lg font-bold'>Last verified artists</h2>
		{#each data.users as user (user.id)}
			<UserPreviewWithWorks {user} />
		{/each}
	</div>
	<div>
		<h2 class='text-lg font-bold'>Discussions</h2>
		{#each data.comments as comment (comment.id)}
			<div class='grid grid-cols-2 gap-3'>
				<WorkPreview work={comment.work} />
				<div
					class='relative prose prose-sm border  border-zinc-200 p-3 pb-6 rounded-md bg-zinc-50 dark:bg-zinc-900 dark:text-white dark:border-zinc-800 space-y-2'
				>
					<div class='whitespace-pre-wrap'>{comment.text}</div>
				</div>
			</div>
		{/each}
	</div>
</div>
