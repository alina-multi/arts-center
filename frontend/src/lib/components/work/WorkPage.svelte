<script lang="ts">
	import type { Work } from '$lib/interfaces/Work';
	import type { Comment } from '$lib/interfaces/Comment';
	import WorkHeader from '$lib/components/work/page/WorkHeader.svelte';
	import WorkBody from '$lib/components/work/page/WorkBody.svelte';
	import RatingPreviewVote from '$lib/components/rating/RatingPreviewVote.svelte';
	import BookmarkButton from '$lib/components/atoms/buttons/BookmarkButton.svelte';
	import ContentFooter from '$lib/components/content/ContentFooter.svelte';
	import { setContext } from 'svelte';
	import { handleIsMy } from '$lib/helpers/handleIsMy';
	import { user } from '$lib/stores/auth';

	export let work: Work;
	export let comments: Comment[];
	setContext('work', work);
	setContext('comments', comments);
	$: isMy = work.owners.some((owner) => handleIsMy($user, owner.id));
</script>

<div
	class="flex flex-col gap-3 mx-auto lg:border border-t-transparent dark:lg:bg-zinc-900 rounded-sm lg:px-28 pt-3 dark:lg:border-zinc-800 dark:lg:border-t-transparent"
>
	<WorkHeader {work} {isMy} />
	<WorkBody {work} />
	<div class="flex items-center justify-between gap-3">
		<div
			class=" w-full flex sm:gap-8 items-center border-t dark:border-zinc-800 py-4 max-lg:border-b max-lg:mb-6 lg:py-6 sm:mt-3"
		>
			<div class="w-full flex items-center justify-between gap-3">
				<RatingPreviewVote entity={work} showVotedPreview votable_type={'work'} />
			</div>
			<BookmarkButton {work} />
		</div>
	</div>
</div>
<ContentFooter commentable_type="work" {isMy} />
