<script lang="ts">
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import { user } from '$lib/stores/auth';
	import { localePath } from '$lib/translations';
	import SideNavLink from '$lib/components/nav/side/SideNavLink.svelte';

	import { getContext } from 'svelte';
	import SideNav from '../nav/side/SideNav.svelte';

	const t = getContext('t');
	const locale = getContext('locale');

	export let threads;
</script>

<SideNav>
	{#each threads as { id, title, lastMessage, exact }}
		<SideNavLink href={localePath($locale, `/my/thread/${id}`)} {exact}>
			<Avatar user={$user} size="h-14 w-14" />
			<div>
				<h3 class="font-semibold">{title}</h3>
				<p class="text-sm text-gray-500 truncate">{lastMessage}</p>
			</div>
		</SideNavLink>
	{/each}
</SideNav>
