<script lang="ts">
	import UserPreviewInline from '$lib/components/user/UserPreviewInline.svelte';
	import EllipsisButton from '$lib/components/atoms/buttons/EllipsisButton.svelte';
	export let work;
</script>

<div class="space-y-1">
	<div class="flex justify-between">
		<div class="flex text-base items-center gap-3">
			{#each work.owners as user}
				<UserPreviewInline {user} />
				<butoon
					class="  dark:bg-gray-900 dark:border-sky-700 dark:border rounded-full px-3 py-1 text-xs text-white bg-sky-700 font-semibold shadow-sm  hover:bg-sky-600 dark:hover:bg-sky-700 dark:text-gray-100 hover:text-white cursor-pointer"
					>Follow</butoon
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
</div>
