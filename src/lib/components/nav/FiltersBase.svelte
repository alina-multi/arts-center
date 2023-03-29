<script lang="ts">
	import FilterOrder from './FilterOrder.svelte';
	import FilterTag from './FilterTag.svelte';
	export let options: {
			order: Array<{ title: string; language: string }>;
			tags: Array<{ title: string; language: string }>;
		},
		urlGenerator: (selected: { order: string; tags: string }) => string,
		selected: { order: string; tags: string };

	$: href = urlGenerator(selected);
	const onOrder = (order: string) => {
		selected.order = order;
		urlGenerator(selected);
	};

	const onTag = (tag: string) => {
		if (tag === selected.tags) {
			selected.tags = 'all';
		} else {
			selected.tags = tag;
			urlGenerator(selected);
		}
	};
</script>

<section aria-labelledby="filter-heading">
	<h2 id="filter-heading" class="sr-only">Filters</h2>
	<div class=" flex  gap-6  py-4 px-3  justify-between ">
		<FilterOrder orders={options.order} {href} selectedOrder={selected.order} {onOrder} />
		<FilterTag tags={options.tags} {href} selectedTag={selected.tags} {onTag} />
	</div>
</section>
