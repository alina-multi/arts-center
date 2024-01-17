<script lang="ts">
	import type { Work } from '$lib/interfaces/Work';
	import type { Comment } from '$lib/interfaces/Comment';
	import WorkHeader from '$lib/components/work/page/WorkHeader.svelte';
	import WorkBody from '$lib/components/work/page/WorkBody.svelte';
	import RatingPreviewVote from '$lib/components/rating/RatingPreviewVote.svelte';
	import { handleIsMy } from '$lib/helpers/handleIsMy';
	import BookmarkButton from '$lib/components/atoms/buttons/BookmarkButton.svelte';
	import { user } from '$lib/stores/auth';
	import ContentFooter from '$lib/components/content/ContentFooter.svelte';

	export let work: Work;
	export let comments: Comment[];
	$: isMy = work.owners.some((owner) => handleIsMy($user, owner.id));
</script>

<div
	class="flex flex-col gap-3 mx-auto lg:border border-t-transparent dark:lg:bg-zinc-900 rounded-sm lg:px-28 py-3 dark:lg:border-zinc-800 dark:lg:border-t-transparent"
>
	<WorkHeader {work} {isMy} />
	<WorkBody {work} />
	<div class="flex items-center justify-between gap-3">
		<div class=" w-full flex gap-3 xs:gap-6 items-center rounded-sm lg:border-0">
			<div class="w-full flex items-center justify-between gap-3 py-6">
				<RatingPreviewVote entity={work} showVotedPreview votable_type={'work'} />
			</div>
			<BookmarkButton {work} />
		</div>
	</div>
</div>
<ContentFooter owners={work.owners} commentable_id={work.id} commentsCount={work.comments} tags={work.tags} {comments} />
