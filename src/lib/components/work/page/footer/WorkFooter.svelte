<script lang="ts">
	import UserFooter from '$lib/components/work/page/footer/UserFooter.svelte';
	import WorkRatingPreview from '$lib/components/work/page/footer/WorkRatingPreview.svelte';
	import MobileButton from '$lib/components/work/page/MobileButtons.svelte';
	export let work;
</script>

<div class="flex flex-col  ">
	<div>
		<div
			class="flex justify-between  mt-1 text-xs sm:text-sm text-gray-700 items-center border rounded-sm lg:hidden  dark:border-transparent bg-gray-100 dark:bg-transparent p-3  dark:text-gray-300 "
		>
			<MobileButton type="like" />
			<MobileButton type="bookmark" />
			<MobileButton type="comment" />
			<MobileButton type="cart" />
		</div>

		<div
			class="flex items-center gap-2 text-xs sm:text-sm  py-1 lg:py-3 justify-end  min-[500px]:justify-between  text-gray-700 border border-x-transparent border-t-transparent  dark:border-b-gray-700 dark:text-gray-500"
		>
			<p class="text-gray-700  lg:pl-3 hidden min-[500px]:block dark:text-gray-400">
				Published at {work.published_at.toLocaleDateString('Ru-ru')}
			</p>

			<WorkRatingPreview {work} />
		</div>
	</div>

	<div
		class="flex items-center gap-3  justify-between text-base py-3 lg:border border-x-transparent border-t-transparent  dark:border-b-gray-700 dark:text-gray-500"
	>
		<UserFooter {work} />
	</div>
</div>
