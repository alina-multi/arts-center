<script>
	import { localePath } from '$lib/translations';
	import FiltersBase from '../nav/FiltersBase.svelte';

	export let tags, params, countries;

	const options = {
		categories: tags,
		order: [
			{
				title: 'popular'
			},
			{
				title: 'new'
			}
		],
		countries: countries
	};

	let urlGenerator = (type, title, params) => {
		const selected = {
			categories: 'all',
			order: 'popular',
			countries: 'all'
		};

		if (params?.order) {
			selected.order = params.order;
		}

		if (params?.category) {
			selected.categories = params.category;
		}

		if (params?.country) {
			selected.countries = params.country;
		}

		let url = '/users';

		if (type === 'order') {
			url += `/${title}/${selected.categories}/${selected.countries}`;
		}
		if (type === 'categories') {
			url += `/${selected.order}/${title}/${selected.countries}`;
		}
		if (type === 'countries') {
			url += `/${selected.order}/${selected.categories}/${title}`;
		}
		// 	if (type === 'order' && title === 'popular' && selected.categories === 'all' && selected.countries === 'all') {
		// 	url = '/users';
		// }
		if (type === 'reset_all') {
			url = '/users';
		}
		if (type === 'reset_order') {
			url = `/users/popular/${selected.categories}/${selected.countries}`;
		}
		if (type === 'reset_categories') {
			url = `/users/${selected.order}/all/${selected.countries}`;
		}
		if (type === 'reset_countries') {
			url = `/users/${selected.order}/${selected.categories}/all`;
		}

		return localePath(url);
	};
</script>

<FiltersBase {options} {urlGenerator} {params} type="usersPage" />

<!-- {#each options.order as { title }}
	<a href={urlGenerator('order', title, params)}
	 class="flex justify-between px-3" >
		{title}
	</a>
{/each}

{#each options.categories as { title }}
	<a href={urlGenerator('categories', title, params)}
	 class="flex justify-between px-3" >
		{title}
	</a>
{/each} -->
