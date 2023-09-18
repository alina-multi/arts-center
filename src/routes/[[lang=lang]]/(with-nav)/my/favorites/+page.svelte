<script>
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Folder } from '@steeze-ui/heroicons';
	import HeaderLayout from '$lib/components/my/HeaderLayout.svelte';

	export let data;
	let folders = data.folders;
</script>

<div>
	<HeaderLayout title="My collections">
		<div slot="details" class="flex gap-3 items-center leading-3">
			<div class="h-1 w-1 bg-gray-500 dark:bg-zinc-300 rounded-full" />
			<span class=""> {folders.length} folders</span>
		</div>
	</HeaderLayout>

	<div
		class="flex flex-col border-x -mt-1 border-b py-3 dark:border-t rounded-b-sm dark:border-zinc-800 dark:bg-zinc-900"
	>
		{#if folders.length > 0}
			{#each folders as folder}
				<a
					href="favorites/{folder.id}"
					class="flex items-center gap-3 px-6 py-3 hover:bg-gray-100 dark:hover:bg-zinc-800"
				>
					<Icon src={Folder} theme="solid" class="h-10 w-10 text-blue-600" />
					<span>{folder.title}</span>
				</a>
			{/each}
		{:else}
			<div class="px-6 py-3">
				Your collections will be here. Save your first favorite work and start creating collections
			</div>
		{/if}
	</div>
</div>
