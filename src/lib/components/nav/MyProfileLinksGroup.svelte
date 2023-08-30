<script>
    import {t}  from '$lib/translations';
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
</script>

<SideNavLink href="/my/profile"
	><Icon src={PencilSquare} theme="solid" class="h-5 w-5 shrink-0" aria-hidden="true" /> {$t('global.my_links.edit_profile')}</SideNavLink
>
<SideNavLink href="/my/work/add"
	><Icon src={PlusCircle} theme="solid" class="h-5 w-5 inline" aria-hidden="true" /> {$t('global.my_links.add_work')}</SideNavLink
>
<SideNavLink href="/my/work/draft"
	><Icon src={FolderOpen} theme="solid" class="h-5 w-5 " aria-hidden="true" />{$t('global.my_links.drafts')}</SideNavLink
>

<SideNavLink href="/my/work/saved"
	><Icon src={Bookmark} theme="solid" class="h-5 w-5 inline" aria-hidden="true" />{$t('global.my_links.saved')}</SideNavLink
>

<SideNavLink href="/my/followers"
	><Icon src={UserGroup} theme="solid" class="h-5 w-5" aria-hidden="true" />{$t('global.my_links.followers')}</SideNavLink
>

<SideNavLink href="/my/following"
	><Icon src={UserPlus} theme="solid" class="h-5 w-5" aria-hidden="true" />{$t('global.my_links.following')}</SideNavLink
>

<SideNavLink href="/my/blacklist"
	><Icon src={NoSymbol} theme="solid" class="h-5 w-5 " aria-hidden="true" />{$t('global.my_links.blocked')}</SideNavLink
>
