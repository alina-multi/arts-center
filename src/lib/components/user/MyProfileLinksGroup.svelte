<script>
	import SideNavLink from '$lib/components/nav/side/SideNavLink.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { PlusCircle, UserGroup, PencilSquare, FolderOpen, UserPlus, Bookmark } from '@steeze-ui/heroicons';
</script>

<SideNavLink href="/my/profile"
	><Icon src={PencilSquare} theme="solid" class="h-5 w-5 shrink-0" aria-hidden="true" /> Edit Profile</SideNavLink
>
<SideNavLink href="/my/work/add"
	><Icon src={PlusCircle} theme="solid" class="h-5 w-5 inline" aria-hidden="true" /> Add work</SideNavLink
>
<SideNavLink href="/my/work/draft"
	><Icon
		src={FolderOpen}
		theme="solid"
		class="h-5 w-5 inline"
		aria-hidden="true"
	/>Drafts</SideNavLink
>

<SideNavLink href="/my/work/saved"
	><Icon
		src={Bookmark}
		theme="solid"
		class="h-5 w-5 inline"
		aria-hidden="true"
	/>Saved</SideNavLink
>

<SideNavLink href="/my/work/followers"
	><Icon
		src={UserGroup}
		theme="solid"
		class="h-5 w-5 inline"
		aria-hidden="true"
	/>Followers</SideNavLink
>

<SideNavLink href="/my/work/Following"
	><Icon
		src={UserPlus}
		theme="solid"
		class="h-5 w-5 inline"
		aria-hidden="true"
	/>Following</SideNavLink
>
