<script lang="ts">
	import FilterOrder from './FilterOrder.svelte';
	import FilterTag from './FilterTag.svelte';
	import FiltersGroup from './FiltersGroup.svelte';

	export let options, urlGenerator, params, type;
</script>

<section aria-labelledby="filter-heading">
	<h2 id="filter-heading" class="sr-only">Filters</h2>
	{#if type === 'galleryPage'}
		<div class=" relative flex gap-1 md:gap-6  justify-between md:text-sm xl:text-base">
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

	<!-- {#if type === 'userPage'}
	<FilterTag tags={options.tags} {href} selectedTag={selected.tags} {onTag} />
{/if} -->

	{#if type === 'usersPage'}
		<div class="divide-y">
			<FiltersGroup
				option={options.order}
				selected={params.order}
				{urlGenerator}
				label={'SORT BY'}
				type={'order'}
				{params}
			/>
			<FiltersGroup
				option={options.categories}
				selected={params.category}
				{urlGenerator}
				label={'CATEGORIES'}
				type={'categories'}
				{params}
			/>
			<FiltersGroup
				option={options.countries}
				selected={params.country}
				{urlGenerator}
				label={'COUNTRIES'}
				type={'countries'}
				{params}
			/>
			<div class="pt-3 flex flex-row-reverse">
				<!-- svelte-ignore a11y-click-events-have-key-events -->
				<!-- svelte-ignore a11y-missing-attribute -->
				<a
					href={urlGenerator('reset_all', '', params)}
					class="text-sm text-gray-500 hover:text-red-700 cursor-pointer"
				>
					Clear all
				</a>
			</div>
		</div>
	{/if}
</section>
