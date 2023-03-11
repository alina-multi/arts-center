<script lang="ts">
	import type { Work } from '$lib/interfaces/Work';
	import WorkHeader from '$lib/components/work/page/header/WorkHeader.svelte';
	import WorkBody from '$lib/components/work/page/body/WorkBody.svelte';
	import WorkFooter from '$lib/components/work/page/footer/WorkFooter.svelte';
	import EllipsisButton from '$lib/components/atoms/buttons/EllipsisButton.svelte';
	import Icons from '$lib/components/atoms/Icons.svelte';
	import TagButton from '$lib/components/atoms/TagButtons.svelte';
	import ButtonsDesktop from './page/DesktopButtons.svelte';

	export let work: Work;
	let tags = [
		{ name: 'Abstract', href: '/' },
		{ name: 'Illustration', href: '/' },
		{ name: 'Abstract', href: '/' },
		{ name: 'Illustration', href: '/' }
	];
</script>

<div class="lg:hidden ">
	<div class="flex justify-between items-center ">
		<Icons type="arrowBack" />
		<div><EllipsisButton /></div>
	</div>
</div>

<div
	class="lg:py-6 p-3 relative text-gray-900 dark:text-gray-100  md:border-gray-100 md:shadow-xl md:border w-full lg:w-10/12  mx-auto dark:md:border-gray-900 "
>
	<div class="hidden lg:block lg:absolute top-8 left-16  justify-between">
		<Icons type="arrowBack" />
	</div>
	<div class="w-full md:w-3/4  mx-auto  space-y-3">
		<div class="flex items-start mx-auto ">
			<div class="flex flex-col gap-1  mx-auto">
				<WorkHeader {work} />
				<WorkBody {work} />
			</div>

			<div class="sticky top-8 right-10 hidden md:block ">
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
		</div>
		<WorkFooter {work} />

		{#if tags.length > 0}
			<div
				class=" flex items-center justify-start flex-wrap gap-1 lg:gap-3 text-xs md:text-base lg:text-base border px-3 py-3 dark:rounded-md bg-gray-100 dark:text-gray-100 dark:bg-gray-900 dark:border-transparent"
			>
				<TagButton {tags} />
			</div>
		{/if}
	</div>
</div>
