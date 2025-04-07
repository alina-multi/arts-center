<script lang="ts">
	import type { Work } from '$lib/interfaces/Work';
	import type { Comment } from '$lib/interfaces/Comment';
	import type { UserWithLastWorks } from '$lib/interfaces/User';
	import WorkHeader from '$lib/components/work/page/WorkHeader.svelte';
	import WorkBody from '$lib/components/work/page/WorkBody.svelte';
	import RatingPreviewVote from '$lib/components/rating/RatingPreviewVote.svelte';
	import BookmarkButton from '$lib/components/atoms/buttons/BookmarkButton.svelte';
	import { setContext } from 'svelte';
	import { handleIsMy } from '$lib/helpers/handleIsMy';
	import { user } from '$lib/stores/auth';
	import AuthModal from '../atoms/AuthModal.svelte';
	import WorkInfoCard from './page/WorkInfoCard.svelte';
	import WorkDescription from '$lib/components/work/page/WorkDescription.svelte';
	import CommentBlocks from '$lib/components/comments/CommentBlocks.svelte';
	import DonateForm from '$lib/components/atoms/DonateForm.svelte';
	import OwnerCard from '../work/page/OwnerCard.svelte';

	export let commentable_type: 'work' | 'post' = 'work',
		work: Work & { owners: UserWithLastWorks[] },
		comments: Comment[];

	$: isMy = work.owners.some((owner) => handleIsMy($user, owner.id));

	$: if (comments) {
		setContext('comments', comments);
	}
	$: if (work) {
		setContext('work', work);
	}
</script>

{#key work.id}
	<div class=" xl:grid xl:grid-cols-[auto_30%] space-y-6 mt-6 xl:gap-16 md:max-xl:px-4">
		<div class="block xl:hidden max-md:px-4"><WorkHeader {work} {isMy} /></div>

		<div class=" space-y-9">
			<WorkBody {work} />
			<WorkDescription {work} />

			<div class="w-full flex items-center justify-between">
				<RatingPreviewVote entity={work} showVotedPreview votable_type={'work'} />
				<BookmarkButton {work} />
			</div>
		</div>
		<WorkInfoCard {work} />
	</div>

	{#each work.owners as owner (owner.id)}
		<div
			class="{owner.verified_at
				? 'xl:grid grid-cols-[auto_30%] xl:gap-16'
				: 'w-full'} md:max-xl:max-w-[770px] mx-auto mt-16"
		>
			<OwnerCard user={owner} {commentable_type} entity={work} />

			<div class="hidden xl:block space-y-9">
				{#if owner.verified_at}
					<DonateForm user={owner} />
				{/if}
			</div>
		</div>

		<CommentBlocks
			{commentable_type}
			commentsCount={work.comments}
			commentable_id={work.id}
			{isMy}
		/>
	{/each}
{/key}

<AuthModal />
