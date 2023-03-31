<script lang="ts">
	import type { Work } from '$lib/interfaces/Work';
	import WorkHeader from '$lib/components/work/page/header/WorkHeader.svelte';
	import WorkBody from '$lib/components/work/page/body/WorkBody.svelte';
	import WorkFooter from '$lib/components/work/page/footer/WorkFooter.svelte';
	import EllipsisButton from '$lib/components/atoms/buttons/EllipsisButton.svelte';
	import Icons from '$lib/components/atoms/Icons.svelte';
	import TagButtons from '$lib/components/atoms/TagButtons.svelte';
	import ButtonsDesktop from './page/DesktopButtons.svelte';
	import CommentsBlock from '$lib/components/comments/CommentsBlock.svelte';
	import WorkRatingPreview from '$lib/components/work/page/footer/WorkRatingPreview.svelte';
	import type { Comment } from '$lib/interfaces/Comment';

	export let work: Work;
	export let comments: Comment[];
</script>

<div class=" relative text-gray-900 mx-auto border px-14 py-3 ">
	<div class=" md:hidden flex justify-between items-center text-gray-600">
		<!-- <div class="rounded-md hover:scale-110 "><Icons type="arrowBack" /></div> -->
		<div><EllipsisButton /></div>
	</div>

	<div>
		<div class="sticky top-0 hidden lg:block">
			<div class="absolute top-[90px] -right-[120px] ">
				<div class="flex flex-col gap-3 text-gray-400 dark:text-gray-500 ">
					<ButtonsDesktop type="cart" />
					<ButtonsDesktop type="like" />
					<ButtonsDesktop type="bookmark" />
					<ButtonsDesktop type="comment" />
					<ButtonsDesktop type="share" />
				</div>
			</div>
		</div>

		<div class="flex flex-col mx-auto gap-3">
			<WorkHeader {work} />
			<WorkBody {work} />
			<div
				class="flex items-center gap-2 text-xs sm:text-base  py-1 lg:py-3 justify-end  min-[500px]:justify-between  text-gray-800  dark:text-gray-500"
			>
				<p class="text-gray-500   hidden min-[500px]:block dark:text-gray-400">
					Published at {work.published_at.toLocaleDateString('Ru-ru')}
				</p>

				<WorkRatingPreview {work} />
			</div>
		</div>
	</div>
</div>

{#if work.tags.length > 0}
	<div
		class=" hidden lg:flex items-center justify-start flex-wrap mt-3 gap-1 lg:gap-3    dark:text-gray-100 "
	>
		<TagButtons tags={work.tags} />
	</div>
{/if}

<WorkFooter {work} />

{#if work.tags.length > 0}
	<div
		class=" flex lg:hidden items-center justify-start flex-wrap  gap-1 text-xs   p-3 rounded-sm border dark:rounded-md bg-gray-100 dark:text-gray-100 dark:bg-gray-900 dark:border-transparent"
	>
		<TagButtons tags={work.tags} />
	</div>
{/if}

<CommentsBlock {comments} />
