<script lang="ts">
	import type { WorkPage } from '../../interfaces/Work';
	import WorkHeader from '$lib/components/work/WorkPage/WorkHeader/WorkHeader.svelte';
	import WorkBody from '$lib/components/work/WorkPage/WorkBody/WorkBody.svelte';
	import WorkFooter from '$lib/components/work/WorkPage/WorkFooter/WorkFooter.svelte';
	import EllipsisButton from '../atoms/Buttons/EllipsisButton.svelte';

	import Icons from '../atoms/Icons.svelte';
	import TagButton from '../atoms/TagButton.svelte';
	import WorkSideBar from './WorkSideBar.svelte';

	BigInt.prototype.toJSON = function () {
		return this.toString();
	};
	export let work: WorkPage;
</script>

<div class="lg:hidden flex justify-between px-3 items-center">
	<Icons type="arrowBack" />
	<div><EllipsisButton /></div>
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
					<WorkSideBar {work} />
				</div>
			</div>
		</div>
		<WorkFooter {work} />
		<TagButton />
	</div>
	
</div>
