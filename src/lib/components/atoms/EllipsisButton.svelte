<script>
	import { Icon } from '@steeze-ui/svelte-icon';
	import { EllipsisVertical, PencilSquare } from '@steeze-ui/heroicons';
	import Dropdown from './Dropdown.svelte';

	export let isMy = false;
</script>

{#if isMy}
	<a href={`/my/work/edit/${work.id}`} class="flex">
		<span class="sr-only">Edit work</span>

		<Icon src={PencilSquare} class="w-7 h-7 text-gray-700 hover:text-gray-500 dark:text-zinc-400" />
	</a>
{:else}
	<Dropdown style="-right-1 z-10 w-40 text-sm mt-2  ">
		<div
			slot="button"
			class="hover:bg-gray-100 cursor-pointer dark:hover:bg-zinc-800 rounded-md py-1"
		>
			<Icon src={EllipsisVertical} class="w-8 h-8 stroke-gray-00 dark:stroke-gray-100 " />
		</div>

		<slot:fragment slot="panel">
			<ul>
				<li class="px-3">
					<a
						href="/"
						class="hover:text-gray-900 hover:bg-gray-100 dark:hover:text-gray-200 dark:hover:bg-gray-600 font-semibold"
						>Something</a
					>
				</li>
			</ul></slot:fragment
		>
	</Dropdown>
{/if}


