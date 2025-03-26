<script lang="ts">
	import type { Work } from '$lib/interfaces/Work';
	import type { Comment } from '$lib/interfaces/Comment';
	import WorkHeader from '$lib/components/work/page/WorkHeader.svelte';
	import WorkBody from '$lib/components/work/page/WorkBody.svelte';
	import RatingPreviewVote from '$lib/components/rating/RatingPreviewVote.svelte';
	import BookmarkButton from '$lib/components/atoms/buttons/BookmarkButton.svelte';
	import { setContext } from 'svelte';
	import { handleIsMy } from '$lib/helpers/handleIsMy';
	import { user } from '$lib/stores/auth';
	import AuthModal from '../atoms/AuthModal.svelte';
	import VerificationBadge from '../atoms/VerificationBadge.svelte';
	import LocaleDate from '$lib/components/atoms/LocaleDate.svelte';
	import WorkDescription from '$lib/components/work/page/WorkDescription.svelte';
	import CommentBlocks from '$lib/components/comments/CommentBlocks.svelte';
	import TagsGroup from '$lib/components/content/TagsGroup.svelte';
	import DonateForm from '$lib/components/atoms/DonateForm.svelte';
	import OwnerCard from '../work/page/OwnerCard.svelte';
	import MoreWorksFromUser from '../work/page/MoreWorksFromUser.svelte';

	import { getContext } from 'svelte';
	export let commentable_type: 'work' | 'post' = 'work',
		isMy: boolean;

	export let work: Work;
	export let comments: Comment[];
	const t = getContext('t');

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
		class=" md:max-lg:max-w-[770px] lg:grid lg:grid-cols-[auto_33%] xl:grid-cols-[auto_30%] space-y-6 mt-6 lg:gap-16 mx-auto md:max-lg:px-4"
	>
		<div class="block lg:hidden max-md:px-4"><WorkHeader {work} {isMy} /></div>

		<div class=" space-y-9">
			<WorkBody {work} />
			<WorkDescription {work} />

			<div class="w-full flex items-center justify-between max-lg:px-4">
				<RatingPreviewVote entity={work} showVotedPreview votable_type={'work'} />
				<BookmarkButton {work} />
			</div>
		</div>

		<div class=" pb-6 px-4 space-y-9 lg:bg-zinc-100 dark:lg:bg-zinc-900 lg:p-9">
			<div class="block max-lg:hidden"><WorkHeader {work} {isMy} /></div>

			<div class="space-y-3">
				<button class="w-full text-lg font-semibold rounded-sm bg-zinc-800 text-white py-3"
					>{$t('global.work_page.ask_artist')}</button
				>

				<div class="lg:space-y-3 text-xs max-lg:flex justify-between items-start">
					<div class=" flex items-center gap-1">
						<VerificationBadge user_verified={user} size={'  w-4 h-4 '} />
						<span class=" text-emerald-500 font-semibold text-sm"
							>{$t('global.work_page.artist_verified')}</span
						>
					</div>
					<div class="space-y-3">
						<!-- 
						we will need  it in the future
						<p class="text-zinc-600 font-semibold max-lg:text-right">{$t('global.work_page.not_available')}</p> -->
						<div class="text-zinc-600 dark:text-zinc-300">
							<span>{$t('global.published_on')}</span>
							<LocaleDate date={work?.published_at} />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="lg:mt-16">
		{#each work.owners as user (user.id)}
			<div
				class=" md:max-lg:max-w-[770px] mx-auto lg:grid lg:grid-cols-[auto_33%] xl:grid-cols-[auto_30%] gap-9 lg:gap-16"
			>
				<div class="space-y-16">
					<div class="  bg-zinc-100 dark:bg-zinc-900 lg:py-12">
						<OwnerCard {user} {commentable_type} entity={work} />
						<div class="block lg:hidden"><DonateForm {user} /></div>
						<!-- last works -->
						<MoreWorksFromUser {user} works={work.images} />
					</div>

					<CommentBlocks
						{commentable_type}
						commentsCount={work.comments}
						commentable_id={work.id}
						{isMy}
					/>
				</div>

				<div class="hidden lg:block space-y-9">
					<DonateForm {user} />
					{#if work.tags}
						<TagsGroup tags={work.tags} media="flex " />
					{/if}
				</div>
			</div>
		{/each}
	</div>
{/key}

<AuthModal />
