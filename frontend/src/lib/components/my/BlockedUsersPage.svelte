<script lang="ts">
	import BlockButton from '$lib/components/atoms/buttons/BlockButton.svelte';
	import UserPreview from '$lib/components/user/UserPreview.svelte';
	import HeaderLayout from '$lib/components/my/HeaderLayout.svelte';
	import { getContext } from 'svelte';

	const t = getContext('t');

	export let blacklist;
</script>

<div>
	<HeaderLayout title={$t('my.blocked')}>
		<span slot="details"> {blacklist.length} </span>
	</HeaderLayout>

	<div class="flex flex-col dark:border-zinc-800 dark:bg-zinc-900">
		{#if blacklist?.length > 0}
			<ul class="lg:divide-y dark:lg:divide-zinc-800">
				{#each blacklist as user (user.id)}
					<li class="flex justify-between items-center gap-x-6 py-3 sm:py-4 px-3 sm:px-6 md:px-9">
						<div class="text-xs max-xs:font-bold font-semibold xs:text-sm xl:text-base">
							<UserPreview
								{user}
								avatar_size={'w-8 h-8 md:w-10 md:h-10'}
								crown_size={'w-3 h-3'}
								followButton={false}
							/>
						</div>

						<BlockButton type="unblock" user_id={user.id} bind:entity={blacklist} />
					</li>
				{/each}
			</ul>
		{:else}
			<p class="px-6 py-3">{$t('my.no_blocked')}</p>
		{/if}
	</div>
</div>
