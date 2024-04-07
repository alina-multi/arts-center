<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { EllipsisHorizontal, EllipsisVertical, PencilSquare } from '@steeze-ui/heroicons';
	import Dropdown from '../Dropdown.svelte';
	import { localePath } from '$lib/translations';
	import { getContext } from 'svelte';

	const locale = getContext('locale');

	export let workId: number | undefined,
		isMy = false,
		type: 'vertical' | 'horizontal' = 'vertical';
</script>

{#if isMy && type === 'vertical'}
	<a
		href={localePath($locale, `/my/work/${workId}/form`)}
		class="flex cursor-pointer"
		data-testid="edit-work-button"
	>
		<span class="sr-only">Edit work</span>

		<Icon
			src={PencilSquare}
			class="w-7 h-7 max-xs:w-5 max-xs:h-5 stroke-1 text-zinc-700 hover:text-zinc-500 dark:text-zinc-400"
		/>
	</a>
{:else}
	<Dropdown style="-right-1 z-10 min-w-40 text-sm mt-2 " z={20}>
		<div slot="button" class="cursor-pointer">
			{#if type === 'horizontal'}
				<Icon src={EllipsisHorizontal} class="w-7 h-7 text-zinc-400 " />
			{:else}
				<Icon src={EllipsisVertical} class="w-7 h-7 text-zinc-700 dark:text-zinc-300" />
			{/if}
		</div>

		<div slot="panel" class="py-1">
			{#if $$slots?.description}
				<slot name="description" />
			{/if}
		</div>
	</Dropdown>
{/if}
