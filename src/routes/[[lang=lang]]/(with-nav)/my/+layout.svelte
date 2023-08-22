<script>
	import SideMenu from '$lib/components/nav/side/SideMenu.svelte';
	import SideNav from '$lib/components/nav/side/SideNav.svelte';
	import { page } from '$app/stores';
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import MyProfileLinksGroup from '$lib/components/nav/MyProfileLinksGroup.svelte';
	let user = $page.data.currentUser;
</script>

<SideMenu style="hidden xl:block ">
	<slot />
	<div slot="nav">
		<SideNav>
			<li class="mx-6 text-left">
				<AvatarLink {user} size="h-12 w-12" withName nameStyles={'font-semibold text-sm'} />
			</li>

			<MyProfileLinksGroup />
		</SideNav>
	</div>
</SideMenu>
