<script lang="ts">
	import UserPreviewList from '$lib/components/user/UserPreviewList.svelte';
	import type { PageData } from './$types';

	export let data: PageData;
	let users = data.users;
	let categories = data.categories;
	let params = data.params;
	let countries = data.countries;


</script>

<UserPreviewList {users} {categories} {params} {countries}/>
