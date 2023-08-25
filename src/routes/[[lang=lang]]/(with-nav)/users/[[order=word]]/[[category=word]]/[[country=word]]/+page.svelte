<script lang="ts">
	import UserPreviewList from '$lib/components/user/UserPreviewList.svelte';
	import type { PageData } from './$types';

	export let data: PageData;
	$: users = data.users;
	$: categories = data.categories;
	$: params = data.params;
	$: countries = data.countries;


</script>



<UserPreviewList {users} {categories} {params} {countries}/>


