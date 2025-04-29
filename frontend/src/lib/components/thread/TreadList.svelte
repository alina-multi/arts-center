<script>
	import { localePath } from '$lib/translations';
	import SideNavLink from '$lib/components/nav/side/SideNavLink.svelte';
	import { getContext } from 'svelte';
	import SideNav from '../nav/side/SideNav.svelte';
	import { threadsStore } from '$lib/stores/auth';
	import ThreadPreview from './ThreadPreview.svelte';

	export let threads;

	const locale = getContext('locale');
	threadsStore.set(threads);
</script>

<SideNav>
	{#each $threadsStore as thread (thread.id)}
		<SideNavLink href={localePath($locale, `/my/thread/${thread.id}`)} exact={thread.exact}>
			<ThreadPreview {...thread} />
		</SideNavLink>
	{/each}
</SideNav>
