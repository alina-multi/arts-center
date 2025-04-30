<script lang="ts">
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import type { Work } from '$lib/interfaces/Work';
	import CrownIcon from '../atoms/CrownIcon.svelte';

	import ImageWork from '$lib/components/atoms/ImageWork.svelte';

	export let work: Work, loading;
</script>

<li class="flex flex-col gap-1 lg:gap-0 overflow-hidden">
	<div class="group/item relative">
		<ImageWork {work} withDesription {loading} />
	</div>

	<div class="flex justify-between items-center lg:text-xs font-medium text-xs sm:text-sm mt-auto">
		<div class="flex items-center gap-1">
			{#each work.owners as user (user.id)}
				<AvatarLink {user} withName={true} size="h-5 w-5" />
			{/each}

			{#if work.subscribed}
				<div class="bg-gray-300 dark:bg-zinc-700 px-1 py-0.5 rounded-sm shadow-sm">
					<CrownIcon style="w-3 h-3 stroke-white dark:stroke-zinc-300" />
				</div>
			{/if}
		</div>
	</div>
</li>
