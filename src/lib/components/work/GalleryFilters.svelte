<script lang="ts">
	import { languageFind, localePath } from '$lib/translations';
	import type { Tag } from '$lib/interfaces/Tag';
	import FiltersBase from '$lib/components/nav/FiltersBase.svelte';

	export let categories: Tag[];
	export let params: {
		tag?: string;
		order?: string;
	};

	console.log('params', params);
	// Map for current language
	const tags = categories.map((category) => {
		return languageFind(category.titles);
	});

	const options = {
		tags: tags,
		order: [
			{
				title: 'popular'
			},
			{
				title: 'new'
			},
			{
				title: 'sale'
			}
		]
	};

	const selected = {
		tags: 'all',
		order: 'popular'
	};

	if (params?.tag) {
		selected.tags = params.tag;
	}
	if (params?.order) {
		selected.order = params.order;
	}

	const urlGenerator = (selected) => {
		if (selected.tags === 'all' && selected.order === 'popular') {
			return localePath('/');
		}
		if (selected.order === 'popular') {
			return localePath(`/tag/${selected.tags}`);
		}

		return localePath(`/tag/${selected.tags}/${selected.order}`);
	};
</script>

<FiltersBase {options} {selected} {urlGenerator} />
