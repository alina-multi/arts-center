<script>
	import SideMenu from '$lib/components/nav/side/SideMenu.svelte';
	import SideNav from '$lib/components/nav/side/SideNav.svelte';
	import { page } from '$app/stores';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import MyProfileLinksGroup from '$lib/components/user/MyProfileLinksGroup.svelte';
	let user = $page.data.currentUser;
</script>

<SideMenu>
	<slot />
	<svelte:fragment slot="nav">
		<SideNav>
			<li class="mx-6 text-left">
				<Avatar {user} size="h-12 w-12" withName nameStyles={'font-semibold text-sm'} />
			</li>

			<MyProfileLinksGroup />
		</SideNav>
	</svelte:fragment>
</SideMenu>
