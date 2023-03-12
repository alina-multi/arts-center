<script lang="ts">
	import UserPreviewInline from '$lib/components/user/UserPreviewInline.svelte';
	import EllipsisButton from '$lib/components/atoms/buttons/EllipsisButton.svelte';
	export let work;
</script>

<div class="space-y-1">
	<div class="flex justify-between">
		<div class="flex text-base items-center gap-2  text-gray-600">
			{#each work.owners as user}
				<UserPreviewInline {user} />
				<div class="w-1 h-1 rounded-full bg-amber-500" />
				<a
					href={user.username}
					class="hover:underline dark:px-3 dark:py-1 dark:border dark:text-sm dark:border-gray-500 dark:rounded-md dark:bg-gray-900 dark:text-gray-300"
					>Follow</a
				>
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

	<p class="text-gray-600 text-sm">
		Published at {work.published_at.toLocaleDateString('Ru-ru')}
	</p>
</div>
