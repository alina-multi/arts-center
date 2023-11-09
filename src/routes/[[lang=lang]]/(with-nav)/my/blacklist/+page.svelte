<script lang="ts">
	import BlockButton from '$lib/components/atoms/buttons/BlockButton.svelte';
	import UserPreview from '$lib/components/user/UserPreview.svelte';
	import HeaderLayout from '$lib/components/my/HeaderLayout.svelte';
	import { t } from '$lib/translations';

	export let data;
	let blacklist = data.blacklist;
</script>

<div>
	<HeaderLayout title={$t('my.blocked')}>
		<span slot="details"> {blacklist.length} {$t('my.people')} </span>
	</HeaderLayout>

	<div class="flex flex-col dark:border-zinc-800 dark:bg-zinc-900">
		{#if blacklist?.length > 0}
			<ul class="lg:divide-y dark:lg:divide-zinc-800">
				{#each blacklist as user (user.id)}
					<li class="flex justify-between items-center gap-x-6 py-3 px-3 sm:px-6">
						<div>
							<UserPreview
								{user}
								avatar_size={'w-12 h-12'}
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
