<script lang="ts">
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import EllipsisButton from '$lib/components/atoms/buttons/EllipsisButton.svelte';
	import FollowButton from '$lib/components/atoms/buttons/FollowButton.svelte';
	import PriceLabel from '$lib/components/atoms/PriceLabel.svelte';
	import ReportButton from '$lib/components/atoms/buttons/ReportButton.svelte';
	import { languageFind } from '$lib/translations';
	import ReportModal from '$lib/components/atoms/ReportModal.svelte';
	import type { Work } from '$lib/interfaces/Work';
	import { getContext } from 'svelte';
	import LocaleDate from '$lib/components/atoms/LocaleDate.svelte';
	import VerificationBadge from '$lib/components/atoms/VerificationBadge.svelte';

	const t = getContext('t');
	const locale = getContext('locale');

	export let work: Work, isMy: boolean;

	let title = languageFind(work.titles, $locale)?.title;
	let modalOpen = false;
</script>

<div class=" flex flex-col gap-3 dark:text-gray-400">
	<div class="flex justify-between items-center">
		{#each work.owners as user (user.id)}
			<div class="flex items-center gap-3">
				<div class="flex items-center gap-1">
					<AvatarLink {user} withName size={'w-8 h-8'} nameStyles={'font-medium text-sm'} />
					<VerificationBadge user_verified={user.verified_at} size={'  w-4 h-4'} />
				</div>
				<div class="flex w-28">
					<FollowButton
						size={'xs   w-max   border border border-zinc-500 border-zinc-800 text-zinc-900 dark:bg-zinc-800  w-min px-3 py-1 text-center'}
						{user}
					/>
				</div>
			</div>
		{/each}

		<div>
			<EllipsisButton workId={work.id} {isMy} type="vertical">
				<div slot="description" class="flex flex-col">
					<ReportButton bind:open={modalOpen} />
				</div>
			</EllipsisButton>
		</div>
	</div>

	<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-1">
		<h1 class="text-xl sm:text-2xl font-medium tracking-wider dark:text-white">
			{title}
		</h1>
		<span class="text-zinc-600 dark:text-zinc-300 text-xs"
			>{$t('global.published_on')} <LocaleDate date={work?.published_at} />
		</span>

		<PriceLabel price={work.price} style={'px-3 py-1 '} />
	</div>
</div>

{#if modalOpen}
	<ReportModal bind:open={modalOpen} feedbackable_type="work" feedbackable_id={Number(work.id)} />
{/if}
