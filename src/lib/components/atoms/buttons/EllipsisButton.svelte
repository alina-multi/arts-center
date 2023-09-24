<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { EllipsisVertical, PencilSquare, EllipsisHorizontal } from '@steeze-ui/heroicons';
	import Dropdown from '../Dropdown.svelte';
	export let work,
		isMy = false,
		type: 'vertical' | 'horizontal' = 'vertical'

		
</script>

{#if isMy && type === 'vertical'}
	<a href={`/my/work/edit/${work.id}`} class="flex">
		<span class="sr-only">Edit work</span>

		<Icon src={PencilSquare} class="w-7 h-7 text-gray-700 hover:text-gray-500 dark:text-zinc-400" />
	</a>
{:else}
	<Dropdown style="-right-1 z-10 min-w-40 text-sm mt-2 " z={20}>
		<div
			slot="button"
			class="hover:bg-gray-100 cursor-pointer dark:hover:bg-zinc-800 rounded-sm py-1 focus:outline-none"
		>
			{#if type === 'horizontal'}
				<Icon
					src={EllipsisHorizontal}
					class="w-7 h-7 text-gray-400 hover:text-gray-500 dark:text-zinc-400"
				/>
			{:else}
				<Icon
					src={EllipsisVertical}
					class="w-7 h-7 text-gray-700 hover:text-gray-500 dark:text-zinc-400"
				/>
			{/if}
		</div>

		<div slot="panel" class="py-1">
			{#if $$slots.description}
				<slot name="description" />
			{/if}
		</div>
	</Dropdown>
{/if}
