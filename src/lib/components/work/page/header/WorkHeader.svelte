<script lang="ts">
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import EllipsisButton from '$lib/components/atoms/EllipsisButton.svelte';
	import FollowButton from '$lib/components/atoms/FollowButton.svelte';

	export let work;
</script>

<div class=" flex flex-col gap-3">
	<div class="flex justify-between items-center">
		<div class="flex flex-col">
			{#each work.owners as user}
				<div class="flex items-center gap-3 text-lg">
					<Avatar {user} withName size={'w-9 h-9'} />

					<FollowButton size={'xs'} {user} />
				</div>
			{/each}
		</div>

		<div class="hidden md:block"><EllipsisButton {work} /></div>
	</div>

	<div class="flex justify-between items-start">
		<h1 class=" text-2xl text-gray-00 dark:text-gray-100">
			{work.titles[0].title}
		</h1>

		{#if work.price}
			<div class="flex gap-1 justify-end">
				<div class=" flex bg-emerald-700 px-3 py-1 rounded-md text-white ml-2">
					${work.price}
				</div>
			</div>
		{/if}
	</div>
</div>
