<script lang="ts">
	import { localePath } from '$lib/translations';
	import FiltersBase from '$lib/components/nav/FiltersBase.svelte';
	export let tags, params;

	const options = {
		tags: tags
	};
	const selected = {
		tags: 'all'
	};
	if (params?.tag) {
		selected.tags = params.tag;
	}

	let urlGenerator = (selected) => {
		if (selected.tags === 'all') {
			return localePath(`/${params?.username}`);
		}
		return localePath(`/${params?.username}/tag/${selected.tags}`);
	};
</script>

<FiltersBase {options} {selected} {urlGenerator} type={'userPage'} />
