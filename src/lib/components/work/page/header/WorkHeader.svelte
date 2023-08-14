<script lang="ts">
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import EllipsisButton from '$lib/components/atoms/EllipsisButton.svelte';
	import FollowButton from '$lib/components/atoms/FollowButton.svelte';
	import PriceLabel from '$lib/components/atoms/PriceLabel.svelte';
	import ReportButton from '$lib/components/atoms/ReportButton.svelte';

	export let work;
	export let isMy = false;
</script>

<div class=" flex flex-col gap-3 dark:text-gray-400">
	<div class="flex justify-between items-center">
		<div class="flex flex-col">
			{#each work.owners as user}
				<div class="flex items-center gap-3">
					<Avatar {user} withName size={'w-8 h-8'} />

					<FollowButton size={'sm'} {user} />
				</div>
			{/each}
		</div>

		<div><EllipsisButton {work} {isMy} type='vertical'>
			<div slot="description"  class="flex flex-col ">
	
		<ReportButton/>
				
			</div>
			</EllipsisButton>
		</div>
	</div>

	<div class="flex justify-between items-start">
		<h1 class="text-xl sm:text-2xl text-gray-00 dark:text-gray-100">
			{work.titles[0].title}
		</h1>

		<!-- {#if work.price}
	
				<div class=" px-3 py-1 ">
					${work.price}
				</div>
		
		{/if} -->

		<PriceLabel price={work.price} style={'px-3 py-1 '} />
	</div>
</div>
