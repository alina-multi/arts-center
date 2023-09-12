<script lang="ts">
	import type { Work } from '$lib/interfaces/Work';
	import type { Comment } from '$lib/interfaces/Comment';
	import type { User } from '$lib/interfaces/User';
	import WorkHeader from '$lib/components/work/page/WorkHeader.svelte';
	import WorkBody from '$lib/components/work/page/WorkBody.svelte';
	import WorkFooter from '$lib/components/work/page/WorkFooter.svelte';
	import RatingPreviewVote from '$lib/components/rating/RatingPreviewVote.svelte';
	import { handleIsMy } from '$lib/helpers/handleIsMy';
	import BookmarkButton from '$lib/components/atoms/buttons/BookmarkButton.svelte';

	export let work: Work;
	export let comments: Comment[];
	export let currentUser: User;
	let isMy = work.owners.some((owner) => handleIsMy(currentUser, owner.id));
</script>

<div
	class="flex flex-col gap-3 mx-auto lg:border border-t-transparent dark:lg:bg-zinc-900 lg:px-28 py-3 dark:lg:border-zinc-800 dark:lg:border-t-transparent"
>
	<WorkHeader {work} {isMy} />
	<WorkBody {work} />
	<div class="flex items-center justify-between gap-3">
		<div
			class=" w-full flex gap-3 items-center max-lg:bg-gray-100 max-lg:px-3 dark:bg-zinc-900 dark:border-zinc-800 text-gray-800 dark:text-zinc-500 border rounded-sm lg:border-0"
		>
			<div class="w-full flex items-center justify-between gap-2 py-3">
				<RatingPreviewVote entity={work} showVotedPreview votable_type={'work'} />
			</div>
			<BookmarkButton {work}/>
		</div>
	</div>
</div>
<WorkFooter {work} {comments} />
