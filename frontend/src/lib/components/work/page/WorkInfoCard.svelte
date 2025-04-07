<script lang="ts">
	import WorkHeader from '$lib/components/work/page/WorkHeader.svelte';
	import GetInTouchButton from '$lib/components/atoms/buttons/GetInTouchButton.svelte';
	import VerificationBadge from '$lib/components//atoms/VerificationBadge.svelte';
	import LocaleDate from '$lib/components/atoms/LocaleDate.svelte';
	import { getContext } from 'svelte';
	import { handleIsMy } from '$lib/helpers/handleIsMy';
	import { user } from '$lib/stores/auth';

	const t = getContext('t');
	export let work;
	$: isMy = work.owners.some((owner) => handleIsMy($user, owner.id));
</script>

<div class=" max-sm:px-4 space-y-6 w-full h-min">
	<div class="block max-xl:hidden"><WorkHeader {work} {isMy} /></div>
	{#each work.owners as owner (owner.id)}
		<div class="space-y-3">
			<GetInTouchButton
				user={owner}
				buttonText={$t('global.work_page.ask_artist')}
				additionalStyles="w-full rounded-none font-semibold  bg-zinc-800 dark:border-zinc-700 dark:border-2 text-white py-3 "
			/>

			<div class="space-y-3 text-xs">
				<div class="flex items-center gap-1">
					<VerificationBadge user_verified={owner} size={'w-4 h-4 lg:hidden'} />

					{#if owner.verified_at}
						<p class="text-emerald-500 font-semibold max-xl:text-sm">
							{$t('global.work_page.artist_verified')}
						</p>
					{/if}
				</div>

				<div class="space-y-3">
					<!-- 
                    we will need  it in the future
                    <p class="text-zinc-600 font-semibold max-lg:text-right">{$t('global.work_page.not_available')}</p> -->
					<div class="text-zinc-500 dark:text-zinc-300">
						<span>{$t('global.published_on')}</span>
						{#if work.published_at}
							<LocaleDate date={new Date(work.published_at)} />
						{/if}
					</div>
				</div>
			</div>
		</div>
	{/each}
</div>

<!-- {#if work.tags} <TagsGroup tags={work.tags}  /> {/if} -->
