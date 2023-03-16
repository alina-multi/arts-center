<script lang="ts">
	import type { Work } from '$lib/interfaces/Work';
	import WorkHeader from '$lib/components/work/page/header/WorkHeader.svelte';
	import WorkBody from '$lib/components/work/page/body/WorkBody.svelte';
	import WorkFooter from '$lib/components/work/page/footer/WorkFooter.svelte';
	import EllipsisButton from '$lib/components/atoms/buttons/EllipsisButton.svelte';
	import Icons from '$lib/components/atoms/Icons.svelte';
	import TagButton from '$lib/components/atoms/TagButtons.svelte';
	import ButtonsDesktop from './page/DesktopButtons.svelte';
	import CommentsBlock from '$lib/components/comments/CommentsBlock.svelte';

	export let work: Work;
	export let comments: any;
	let tags = [
		{ name: 'Abstract', href: '/' },
		{ name: 'Illustration', href: '/' },
		{ name: 'Abstract', href: '/' },
		{ name: 'Illustration', href: '/' }
	];
</script>

<div
	class=" py-3 px-3 md:px-0 relative text-gray-900 dark:text-gray-100  md:border-gray-100  md:border w-full  mx-auto dark:md:border-gray-900 "
>
	<div class=" md:hidden flex justify-between items-center">
		<Icons type="arrowBack" />
		<div><EllipsisButton /></div>
	</div>
	<div class="hidden md:block md:absolute top-4 lg:left-16 md:left-10 ">
		<Icons type="arrowBack" />
	</div>
	<div class="w-full md:w-3/4  mx-auto">
		<div>
			<div class="sticky  hidden md:block">
				<div class="absolute top-28 -right-[72px] xl:-right-[90px]">
					<div class="flex flex-col gap-3 text-gray-400 dark:text-gray-500 ">
						<ButtonsDesktop type="cart" />
						<ButtonsDesktop type="like" />
						<ButtonsDesktop type="bookmark" />
						<ButtonsDesktop type="comment" />
						<ButtonsDesktop type="share" />
					</div>
				</div>
			</div>

			<div class="flex flex-col mx-auto gap-1">
				<WorkHeader {work} />
				<WorkBody {work} />
			</div>
		</div>
		<WorkFooter {work} />
	</div>

	{#if tags.length > 0}
		<div
			class=" flex items-center justify-start flex-wrap gap-1 lg:gap-3 text-xs md:text-base lg:text-base border px-3 py-3 dark:rounded-md bg-gray-100 dark:text-gray-100 dark:bg-gray-900 dark:border-transparent"
		>
			<TagButton {tags} />
		</div>
	{:else}
		<div class=" border-b" />
	{/if}

	<div class="w-full md:w-3/4  mx-auto  ">
		<CommentsBlock {comments} />
	</div>
</div>
