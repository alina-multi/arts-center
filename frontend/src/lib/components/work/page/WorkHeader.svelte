<script lang="ts">
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import EllipsisButton from '$lib/components/atoms/buttons/EllipsisButton.svelte';
	import FollowButton from '$lib/components/atoms/buttons/FollowButton.svelte';
	import ReportButton from '$lib/components/atoms/buttons/ReportButton.svelte';
	import { languageFind } from '$lib/translations';
	import ReportModal from '$lib/components/atoms/ReportModal.svelte';
	import type { Work } from '$lib/interfaces/Work';
	import { getContext } from 'svelte';
	import VerificationBadge from '$lib/components/atoms/VerificationBadge.svelte';

	const t = getContext('t');
	const locale = getContext('locale');

	export let work: Work, isMy: boolean;

	let title = languageFind(work.titles, $locale)?.title;
	let modalOpen = false;
</script>

<div class=" space-y-3">
	<div class="flex justify-between items-center">
		{#each work.owners as user (user.id)}
			<div class="flex items-center gap-3">
				<div class="flex items-center gap-1">
					<AvatarLink {user} withName size={'w-8 h-8'} nameStyles={'font-medium text-sm '} />
					<VerificationBadge user_verified={user.verified_at} size={'  w-4 h-4 lg:hidden'} />
				</div>

				<FollowButton
					addStyles={'text-xs border-1 rounded-full py-0 dark:bg-zinc-900 lg:hidden'}
					{user}
				/>
			</div>
		{/each}

		<div>
			<EllipsisButton workId={work.id} {isMy} type="horizontal">
				<div slot="description" class="flex flex-col">
					<ReportButton bind:open={modalOpen} />
				</div>
			</EllipsisButton>
		</div>
	</div>

	<div class=" flex justify-between flex-wrap gap-3 items-center">
		<h1 class="text-xl sm:text-2xl font-bold dark:text-white inline-flex">
			{@html title}
		</h1>
	</div>
</div>

{#if modalOpen}
	<ReportModal bind:open={modalOpen} feedbackable_type="work" feedbackable_id={Number(work.id)} />
{/if}
