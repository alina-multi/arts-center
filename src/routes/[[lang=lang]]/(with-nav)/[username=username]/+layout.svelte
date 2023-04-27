<script lang="ts">
	import WorkFilters from '$lib/components/user/WorkFilters.svelte';
	import type { PageData } from './$types';
	import UserCard from '$lib/components/user/UserCard.svelte';

	export let data: PageData;
	let userTags = data.user.ratings.map((rating) => rating.tag);
	let isBioOpen = false;
</script>

<div class="flex flex-col xl:flex-row gap-3  mt-3 ">
	<div class=" xl:w-1/4 rounded-md shadow-sm border ">
		<UserCard user={data.user} />
	</div>

	<div class="flex flex-col gap-3 xl:w-3/4 ">
		<WorkFilters tags={userTags} params={data.params} />
		<div class="relative flex flex-col items-center md:items-end text-sm lg:text-base ">
			<div
				class="{isBioOpen
					? ''
					: ' h-24  overflow-hidden text-transparent bg-clip-text bg-gradient-to-b from-gray-900  to-transparent'}  "
			>
				{data.user.bio}
			</div>

			<div class="{isBioOpen ? ' ' : ' absolute bottom-0'} ">
				<button
					on:click={() => (isBioOpen = !isBioOpen)}
					class=" pl-2 xl:pr-6 rounded-full  text-amber-900 bg-white underline hover:text-sky-800"
					>{isBioOpen ? 'Show less' : 'Read more ...'}</button
				>
			</div>
		</div>

		<slot />
	</div>
</div>
