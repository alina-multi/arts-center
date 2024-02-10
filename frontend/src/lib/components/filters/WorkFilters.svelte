<script lang="ts">
	import { localePath } from '$lib/translations';
	import FilterTag from '$lib/components/filters/FilterTag.svelte';
	import { page } from '$app/stores';
	import { getContext } from 'svelte';

	export let tags, params: { username: string; tag: string };
	const locale = getContext('locale');

	$: path = $page.url.pathname.split('/');
	$: index = path.findIndex((el) => el === 'tag');
	$: selected = index === -1 ? 'all' : path[index + 1];

	const options = {
		tags: tags
	};

	$: urlGenerator = (
		_: undefined,
		title: string,
		params: { username: string },
		selected: string
	) => {
		if (selected === title) {
			return localePath($locale, `/${params?.username}`);
		}
		return localePath($locale, `/${params?.username}/tag/${title}`);
	};
</script>

<FilterTag tags={options.tags} {selected} {urlGenerator} {params} />
