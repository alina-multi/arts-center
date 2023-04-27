<script lang="ts">
	import { localePath } from '$lib/translations';
	import FiltersBase from '$lib/components/nav/FiltersBase.svelte';
	export let tags, params;

	const options = {
		tags: tags
	};

	let urlGenerator = (type, title, params) => {
		const selected = {
			tags: 'all'
		};
		if (params?.tag !== 'all') {
			selected.tags = params.tag;
		}

		if (selected.tags === title) {
			return localePath(`/${params?.username}`);
		}
		return localePath(`/${params?.username}/tag/${title}`);
	};
</script>

<FiltersBase {options} {params} {urlGenerator} type={'userPage'} />
