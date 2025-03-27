<script lang="ts">
	import Picture from '$lib/components/atoms/Picture.svelte';
	import type { UserWithLastWorks } from '$lib/interfaces/User';
	import { localePath } from '$lib/translations';
	import { getContext } from 'svelte';

	export let user: UserWithLastWorks;
	const locale = getContext('locale');
	const t = getContext('t');
</script>

<div class="space-y-6 bg-zinc-60 mt-6 px-6 lg:px-9">
	<p class="font-bold inline">{$t('global.work_page.more_works')}</p>

	<a href={localePath($locale, `/${user.username}`)} class="underline inline font-bold">
		{user.name}
	</a>

	<div class="grid grid-cols-3 lg:grid-cols-6 gap-3">
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
