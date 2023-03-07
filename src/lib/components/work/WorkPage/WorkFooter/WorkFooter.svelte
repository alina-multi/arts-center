<script lang="ts">
	import MobileButtons from '$lib/components/work/MobileButtons.svelte';
	import UserFooter from '$lib/components/work/WorkPage/WorkFooter/UserFooter.svelte';
	import WorkRatingPreview from '$lib/components/work/WorkPage/WorkFooter/WorkRatingPreview.svelte';
	export let work;
</script>

<div class="flex flex-col ">
	<div>
		<MobileButtons {work} />

		<div
			class="flex items-center  gap-2 px-3 py-1  justify-between  text-gray-700 border border-x-transparent border-t-transparent  dark:border-b-gray-700 dark:text-gray-500">
			<WorkRatingPreview {work}/>
		</div>
	</div>

	<div
		class="flex items-center gap-2 justify-between text-base px-3 py-3  border-x-transparent border-t-transparent  dark:border-b-gray-700 dark:text-gray-500">
		<UserFooter {work} />
	</div>
</div>
