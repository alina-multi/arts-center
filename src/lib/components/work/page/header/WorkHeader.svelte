<script lang="ts">
	import UserPreviewInline from '$lib/components/user/UserPreviewInline.svelte';
	import EllipsisButton from '$lib/components/atoms/EllipsisButton.svelte';
	export let work;
</script>

<div class="space-y-1 py-2">
	<div class="flex justify-between items-center">
		<div class="flex flex-col">
			{#each work.owners as user}
				<UserPreviewInline {user} followButton={true} size={'w-8 h-8'} />
			{/each}
		</div>
		<div class="hidden md:block"><EllipsisButton /></div>
	</div>

	<div class="flex justify-between items-start">
		<h1 class=" text-2xl  text-gray-00 dark:text-gray-100">
			{work.titles[0].title}
		</h1>

		{#if work.price}
			<div class="flex gap-1 justify-end">
				<div class=" flex  bg-emerald-700 px-3 py-1 rounded-md text-white ml-2">
					${work.price}
				</div>
			</div>
		{/if}
	</div>
</div>
