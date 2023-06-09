<script lang="ts">
	import FilterOrder from './FilterOrder.svelte';
	import FilterTag from './FilterTag.svelte';

	export let options, urlGenerator, params, type;
</script>

<section aria-labelledby="filter-heading">
	<h2 id="filter-heading" class="sr-only">Filters</h2>
	{#if type === 'galleryPage'}
		<div class=" relative flex gap-1 md:gap-6 justify-between md:text-sm xl:text-base">
			<FilterOrder
				option={options.order}
				selectedOrder={params.order}
				{urlGenerator}
				type={'order'}
				{params}
			/>

			<FilterTag tags={options.tags} selected={params.tag} {urlGenerator} type={'tags'} {params} />
		</div>
	{/if}
</section>
