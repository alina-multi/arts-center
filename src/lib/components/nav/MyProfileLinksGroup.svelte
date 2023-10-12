<script>
	import {t, localePath}  from '$lib/translations';
	import SideNavLink from '$lib/components/nav/side/SideNavLink.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import {
		PlusCircle,
		UserGroup,
		PencilSquare,
		FolderOpen,
		UserPlus,
		Bookmark,
		NoSymbol
	} from '@steeze-ui/heroicons';
	import { user } from '$lib/stores/auth';

	let folders = $user?.favorites?.folders;
	const favorites_href = folders.length === 0 || folders.length > 1 ?  "/my/favorites" : "/my/favorites/"+folders[0].id;
</script>

<SideNavLink href={localePath("/my/profile")}
	><Icon src={PencilSquare} theme="solid" class="h-5 w-5 shrink-0" aria-hidden="true" /> {$t('global.my_links.edit_profile')}</SideNavLink
>
<SideNavLink href={localePath("/my/work/add")}
	><Icon src={PlusCircle} theme="solid" class="h-5 w-5 inline" aria-hidden="true" /> {$t('global.my_links.add_work')}</SideNavLink
>
<SideNavLink exact href={localePath("/my/work")}
	><Icon src={FolderOpen} theme="solid" class="h-5 w-5 " aria-hidden="true" />{$t('global.my_links.works')}</SideNavLink
>

<SideNavLink href={localePath(`${favorites_href}`)}
	><Icon src={Bookmark} theme="solid" class="h-5 w-5 inline" aria-hidden="true" />{$t('global.my_links.favorites')}</SideNavLink
>

<SideNavLink href={localePath("/my/followers")}
	><Icon src={UserGroup} theme="solid" class="h-5 w-5" aria-hidden="true" />{$t('global.my_links.followers')}</SideNavLink
>

<SideNavLink href={localePath("/my/following")}
	><Icon src={UserPlus} theme="solid" class="h-5 w-5" aria-hidden="true" />{$t('global.my_links.following')}</SideNavLink
>

<SideNavLink href={localePath("/my/blacklist")}
	><Icon src={NoSymbol} theme="solid" class="h-5 w-5 " aria-hidden="true" />{$t('global.my_links.blocked')}</SideNavLink
>
