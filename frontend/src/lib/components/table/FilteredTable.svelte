<script lang="ts">
	import type { SvelteComponent } from 'svelte';

	interface Column {
		title: string;
		field?: string; // defaults to title if not set
		sortable?: boolean;
		filterable?: boolean;
		propsFn?();
		valueFn?();

		component?: SvelteComponent;
	}

	export let data: object;
	export let columns: Column[];
	export let keyColumn = 'id';

	function getCellValue(row, column) {
		if (column?.valueFn) {
			return column.valueFn(row);
		} else {
			return row[column.field];
		}
	}

	function getProps(row, column) {
		return {
			...row,
			...(column.propsFn ? column?.propsFn(row, column) : {})
		};
	}
</script>

<table class=" w-full divide-y divide-zinc-300 dark:divide-zinc-700">
	<thead>
		<tr class="space-x-3">
			{#each columns as column (column.title)}
				<th
					scope="col"
					class="sm:px-6 px-3 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-white"
				>
					{column.title}
				</th>
			{/each}
		</tr>
	</thead>
	<tbody>
		{#each data as row (row[keyColumn])}
			<tr class="space-x-3 even:bg-zinc-100 dark:even:bg-zinc-900">
				{#each columns as column}
					<td class="sm:px-6 px-3 py-4 text-sm text-zinc-500 dark:text-zinc-400">
						{#if column?.component}
							<svelte:component this={column.component} {...getProps(row, column)} />
						{:else}
							<!-- eslint-disable-next-line -->
							{@html getCellValue(row, column)}
						{/if}
					</td>
				{/each}
			</tr>
		{/each}
	</tbody>
</table>
