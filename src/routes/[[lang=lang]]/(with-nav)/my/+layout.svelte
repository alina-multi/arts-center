<script>
  import SideMenu from "$lib/components/nav/side/SideManu.svelte";
  import SideNav from "$lib/components/nav/side/SideNav.svelte";
  import SideNavLink from "$lib/components/nav/side/SideNavLink.svelte";
  import { Icon } from '@steeze-ui/svelte-icon';
  import { PlusCircle, Pencil, PencilSquare } from '@steeze-ui/heroicons';
  import { page } from '$app/stores';
  import Avatar from "$lib/components/atoms/Avatar.svelte";
  let user = $page.data.currentUser;
</script>

<SideMenu>
  <slot/>
  <svelte:fragment slot="nav">
    <SideNav>
      <li class="mx-6 text-center">
        <Avatar {user} size="h-12 w-12"/>
      </li>
      <SideNavLink href="/my/profile"><Icon src={Pencil} theme="solid" class="h-6 w-6 shrink-0" aria-hidden="true" /> Edit Profile</SideNavLink>
      <SideNavLink href="/my/work/add"><Icon src={PlusCircle} theme="solid" class="h-5 w-5 inline" aria-hidden="true" /> Add work</SideNavLink>
      <SideNavLink href="/my/work/draft"><Icon src={PencilSquare} theme="solid" class="h-5 w-5 inline" aria-hidden="true" />Drafts</SideNavLink>
    </SideNav>
  </svelte:fragment>
</SideMenu>