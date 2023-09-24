<script lang="ts">
	import UserPreviewList from '$lib/components/user/UserPreviewList.svelte';
	import type { PageData } from './$types';
	import MetaGroups from '$lib/components/MetaGroups.svelte';
	import {t} from '$lib/translations'

	export let data: PageData;
	$: users = data.users;
	$: categories = data.categories;
	$: params = data.params;
	$: countries = data.countries;
</script>

<MetaGroups title={$t('global.seo.title.users', params)}></MetaGroups>



<UserPreviewList {users} {categories} {params} {countries}/>


