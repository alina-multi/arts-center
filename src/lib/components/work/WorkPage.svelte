<script lang="ts">
	import type { Work } from '$lib/interfaces/Work';
	import WorkHeader from '$lib/components/work/page/header/WorkHeader.svelte';
	import WorkBody from '$lib/components/work/page/body/WorkBody.svelte';
	import WorkFooter from '$lib/components/work/page/footer/WorkFooter.svelte';
	import { HandThumbUp } from '@steeze-ui/heroicons';
	import { Icon } from '@steeze-ui/svelte-icon';
	import TagButtons from '$lib/components/atoms/TagButtons.svelte';
	import ButtonsDesktop from './page/DesktopButtons.svelte';
	import WorkRatingPreview from '$lib/components/work/page/footer/WorkRatingPreview.svelte';
	import type { Comment } from '$lib/interfaces/Comment';

	export let work: Work;
	export let comments: Comment[];
</script>

{JSON.stringify(work)}
<div
	class=" relative mx-auto lg:border border-t-transparent lg:px-14 py-3 dark:border-gray-800 dark:border-t-transparent "
>
	<!-- <div class=" md:hidden flex justify-between items-center text-gray-600">
		<div class="rounded-md hover:scale-110 "><Icons type="arrowBack" /></div>
		<div><EllipsisButton /></div>
	</div> -->

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
				class="flex items-center justify-between   gap-2 text-base  lg:py-3 pb-3 	max-lg:pr-3  text-gray-800  dark:text-gray-500 max-lg:border-b"
			>
				<div
					class=" hidden lg:flex items-center justify-start flex-wrap gap-3  dark:text-gray-100 "
				>
					{#if work.tags.length > 0}
						<span>Tags:</span>
						<TagButtons tags={work.tags} dots />
					{/if}
				</div>

				<WorkRatingPreview {work} />
				<button
					class="  flex lg:hidden  bg-sky-700 text-white border p-2 rounded-full  hover:text-sky-700 hover:shadow-md  hover:bg-gray-50 dark:hover:bg-gray-900  dark:hover:border-gray-400"
				>
					<Icon src={HandThumbUp} theme="solid" class="w-6 h-6 " />
				</button>
			</div>
		</div>
	</div>
</div>

<WorkFooter {work} {comments} />
