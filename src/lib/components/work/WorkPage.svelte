<script lang="ts">
	import type { Work } from '$lib/interfaces/Work';
	import type { Comment } from '$lib/interfaces/Comment';
	import WorkHeader from '$lib/components/work/page/header/WorkHeader.svelte';
	import WorkBody from '$lib/components/work/page/body/WorkBody.svelte';
	import WorkFooter from '$lib/components/work/page/footer/WorkFooter.svelte';
	import RatingPreviewVote from '$lib/components/rating/RatingPreviewVote.svelte';
	export let work: Work;
	export let comments: Comment[];
	import { page } from '$app/stores';

	const currentUser = $page.data.user;
</script>

<div
	class=" relative mx-auto lg:border border-t-transparent lg:px-14 py-3 dark:border-gray-800 dark:border-t-transparent"
>
	<div class="sticky top-0 hidden lg:block">
		<div class="absolute top-[90px] -right-[120px]">
			<div class="flex flex-col gap-3 text-gray-400 dark:text-gray-500">
				<!-- <ButtonsDesktop type="like" /> -->
			</div>
		</div>
	</div>
	<div>
		<div class="flex flex-col mx-auto gap-3">
			<WorkHeader {work} />
			<WorkBody {work} />
			<div
				class="flex items-center justify-between gap-2 lg:py-3 pb-3 text-gray-800 dark:text-gray-500"
			>
				<RatingPreviewVote
					entity={work}
					{currentUser}
					showVotedPreview
					votable_type={'work'}
					size={'md'}
				/>
			</div>
		</div>
	</div>
</div>

<WorkFooter {work} {comments} />
