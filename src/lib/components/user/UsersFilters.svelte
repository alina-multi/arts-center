<script>
	import { localePath } from '$lib/translations';
	import UserFiltersGroup from '$lib/components/user/UserFiltersGroup.svelte';

	export let tags, params, countries;

	const filterKeys = ['order', 'category', 'country'];
	const options = {
		order: [
			{
				title: 'popular'
			},
			{
				title: 'new'
			}
		],
		country: countries,
		category: tags
	};

	const defaultParams = {
		order: 'popular',
		category: 'all',
		country: 'all'
	};

	function urlGenerator(params, changes) {
		const newState = { ...params, ...changes };
		let url = '/users';
		// Compare the new state with the default state
		if (Object.keys(defaultParams).every((key) => newState[key] === defaultParams[key])) {
			return url;
		}
		for (let key of filterKeys) {
			url += `/${newState[key]}`;
		}
		return localePath(url);
	}
</script>

<section aria-labelledby="filter-heading">
	<h2 id="filter-heading" class="sr-only">Filters</h2>
	<div class="divide-y dark:divide-gray-700">
		{#each filterKeys as group}
			<UserFiltersGroup options={options[group]} {params} {group} {urlGenerator} />
		{/each}

		<div class="pt-3 flex flex-row-reverse">
			<a
				href={urlGenerator(params, defaultParams)}
				class="text-sm text-gray-500 hover:text-red-700 cursor-pointer"
			>
				Clear all
			</a>
		</div>
	</div>
</section>
