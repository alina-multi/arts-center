<script lang="ts">
	import WorkFilters from '$lib/components/filters/WorkFilters.svelte';
	import type { PageData } from './$types';
	import UserCard from '$lib/components/user/UserCard.svelte';
	import Biography from '$lib/components/user/Biography.svelte';
	import SideMenu from '$lib/components/nav/side/SideMenu.svelte';

	export let data: PageData;
	let userTags = data.user.ratings.map((rating) => rating.tag);
</script>

<SideMenu>
	<svelte:fragment slot="nav"><UserCard user={data.user} /></svelte:fragment>
	{#if userTags.length > 0}
		<div class="w-full relative"><WorkFilters tags={userTags} params={data.params} /></div>
	{/if}
	<Biography user={data.user} />
	<slot />
</SideMenu>
