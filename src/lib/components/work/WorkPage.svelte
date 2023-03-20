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
	import type { Comment } from "../../interfaces/Comment";

	export let work: Work;
	export let comments: Comment[];
	const tags = work.tags;
</script>

<div class=" px-3 md:p-3  relative text-gray-900 mx-auto  ">
	<div class=" md:hidden flex justify-between items-center text-gray-600">
		<div class="rounded-md hover:scale-110 "><Icons type="arrowBack" /></div>
		<div><EllipsisButton /></div>
	</div>

	<div>
		<div class="sticky top-0 hidden lg:block">
			<div class="absolute top-[90px] -right-[60px] xl:-right-[66px]">
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
		</div>
	</div>

	{#if tags.length > 0}
		<div
			class=" hidden lg:flex items-center justify-start flex-wrap mt-3 gap-1 lg:gap-3 text-xs md:text-base p-3 rounded-md border dark:rounded-md bg-gray-50 dark:text-gray-100 dark:bg-gray-900 dark:border-transparent"
		>
			<TagButtons {tags} />
		</div>
	{/if}

	<WorkFooter {work} />

	{#if tags.length > 0}
		<div
			class=" flex lg:hidden items-center justify-start flex-wrap  gap-1 text-xs   p-3 rounded-sm border dark:rounded-md bg-gray-100 dark:text-gray-100 dark:bg-gray-900 dark:border-transparent"
		>
			<TagButtons {tags} />
		</div>
	{/if}

	<CommentsBlock {comments} />
</div>
