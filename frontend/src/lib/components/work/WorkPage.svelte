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
	import AuthModal from '../atoms/AuthModal.svelte';

	export let work: Work;
	export let comments: Comment[];

	$: isMy = work.owners.some((owner) => handleIsMy($user, owner.id));

	$: if (comments) {
		setContext('comments', comments);
	}
	$: if (work) {
		setContext('work', work);
	}
</script>

{#key work.id}
	<div
		class="flex flex-col gap-3 lg:gap-6 mx-auto pt-3 lg:pt-9 dark:lg:bg-zinc-900 lg:px-28 xl:px-36"
	>
		<WorkHeader {work} {isMy} />
		<WorkBody {work} />

		<div class="flex items-center justify-between gap-3">
			<div
				class=" w-full flex sm:gap-3 items-center sm:mt-3 sm:border-y lg:border-b-transparent lg:dark:border-b-transparent dark:border-zinc-800 py-4 lg:py-6"
			>
				<div class="w-full flex items-center justify-between gap-3 max-sm:ml-3">
					<RatingPreviewVote entity={work} showVotedPreview votable_type={'work'} />
				</div>
				<BookmarkButton {work} />
			</div>
		</div>
	</div>

	<div class="flex flex-col gap-3 lg:gap-6 px-4 xs:mx-auto lg:pt-9 lg:px-28 xl:px-36 dark:xl:px-0">
		<ContentFooter commentable_type="work" {isMy} />
	</div>
{/key}
<AuthModal />
