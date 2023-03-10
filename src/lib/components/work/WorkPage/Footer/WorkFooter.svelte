<script lang="ts">
	import UserFooter from '$lib/components/work/WorkPage/Footer/UserFooter.svelte';
	import WorkRatingPreview from '$lib/components/work/WorkPage/Footer/WorkRatingPreview.svelte';
	import MobileButton from '$lib/components/work/WorkPage/MobileButtons.svelte';
	export let work;
</script>

<div class="flex flex-col ">
	<div>
		<div
			class="flex justify-between  text-sm sm:text-sm text-gray-700 items-center md:hidden border dark:border-transparent bg-gray-100 dark:bg-transparent px-4 py-2 dark:text-gray-300 "
		>
			<MobileButton type="like" />
			<MobileButton type="bookmark" />
			<MobileButton type="comment" />
			<MobileButton type="cart" />
		</div>
		<div
			class="flex items-center  gap-2 px-3 py-1  justify-end  text-gray-700 border border-x-transparent border-t-transparent  dark:border-b-gray-700 dark:text-gray-500"
		>
			<WorkRatingPreview {work} />
		</div>
	</div>

	<div
		class="flex items-center gap-2 justify-between text-base px-3 py-3  border-x-transparent border-t-transparent  dark:border-b-gray-700 dark:text-gray-500"
	>
		<UserFooter {work} />
	</div>
</div>
