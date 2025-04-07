<script lang="ts">
	import Picture from '$lib/components/atoms/Picture.svelte';
	import type { UserWithLastWorks } from '$lib/interfaces/User';
	import { localePath } from '$lib/translations';
	import { getContext } from 'svelte';

	export let user: UserWithLastWorks;
	const locale = getContext('locale');
	const t = getContext('t');
</script>

<div
	class="space-y-9 max-lg:mb-9 max-xl:pt-9 px-4 md:px-6 lg:px-0 {user.verified_at
		? ' xl:bg-zinc-100 xl:dark:bg-transparent xl:dark:mt-9 xl:px-9 xl:p-9 xl:pt-1 mb-16'
		: ' my-12  '} "
>
	<div class="inline-flex items-center gap-2 font-bold text-lg">
		<p class="inline">{$t('global.work_page.more_works')}</p>

		<a href={localePath($locale, `/${user.username}`)} class="underline">
			{user.name}
		</a>
	</div>

	<div
		class="grid grid-cols-3 {user.verified_at ? '  xl:grid-cols-3' : '  xl:grid-cols-6'}   gap-6"
	>
		{#each user.last_works as work}
			<a
				href={localePath($locale, `/work/${work.id}`)}
				class="aspect-1 overflow-hidden hover:opacity-80 transition-opacity block"
			>
				<Picture
					photo={work.preview}
					alt={work.titles[0]?.title || 'Thumbnail'}
					class="w-full h-full object-cover"
				/>
			</a>
		{/each}
	</div>
</div>
