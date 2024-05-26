<script lang="ts">
	import { localePath } from '$lib/translations';
	import type { Tag } from '$lib/interfaces/Tag';
	import FiltersBase from '$lib/components/filters/FiltersBase.svelte';
	import { getContext } from 'svelte';

	const locale = getContext('locale');

	export let categories: Tag[];
	export let params: {
		tag?: string;
		order?: string;
	};

	const options = {
		tags: categories,
		order: [
			{
				title: 'trending'
			},
		
			{
				title: 'rising'
			},
			
		
			{
				title: 'new'
			},
			{
				title: 'popular'
			},
		
		
		]
	};

	let urlGenerator = (type: string, title: string, params: { tag?: string; order?: string }) => {
		const selected = {
			tags: 'all',
			order: 'trending'
		};

		if (params?.tag) {
			selected.tags = params.tag;
		}
		if (params?.order) {
			selected.order = params.order;
		}

		let url = '/';

		if (type === 'order') {
			url += `tag/${selected.tags}/${title}`;
		}

		if (type === 'tags') {
			if (title === selected.tags) {
				url += `tag/all/${selected.order}`;
			} else {
				url += `tag/${title}/${selected.order}`;
			}
		}

		return localePath($locale, url);
	};
</script>

<FiltersBase {options} {params} {urlGenerator} type={'galleryPage'} />
