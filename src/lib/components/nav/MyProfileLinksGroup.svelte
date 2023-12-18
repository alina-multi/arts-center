<script>
	import { t, localePath } from '$lib/translations';
	import SideNavLink from '$lib/components/nav/side/SideNavLink.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import {
		PlusCircle,
		UserGroup,
		PencilSquare,
		FolderOpen,
		UserPlus,
		Bookmark,
		NoSymbol,
		CurrencyDollar,
		Camera,
		Bell,
		ArrowUpOnSquareStack,
		RectangleStack
	} from '@steeze-ui/heroicons';
	import { user } from '$lib/stores/auth';

	let folders = $user?.favorites?.folders;
	const favorites_href = folders.length === 0 || folders.length > 1 ? '/my/favorites' : '/my/favorites/' + folders[0].id;
	const links = [
		{
			path: '/my/notifications',
			src: Bell,
			text: 'notifications'
		},
		{
			path: '/my/profile',
			src: PencilSquare,
			text: 'edit_profile'
		},
		{
			path: '/my/photo',
			src: Camera,
			text: 'avatar'
		},
		{
			path: '/my/work/add',
			src: PlusCircle,
			text: 'add_work'
		},
		{
			path: '/my/work',
			src: FolderOpen,
			text: 'works',
			exact: true
		},
		{
			path: '/my/post/add',
			src: ArrowUpOnSquareStack,
			text: 'add_post'
		},
		{
			path: '/my/post',
			src: RectangleStack,
			text: 'posts',
			exact: true
		},
		{
			path: '/my/transactions',
			src: CurrencyDollar,
			text: 'transactions'
		},
		{
			path: favorites_href,
			src: Bookmark,
			text: 'favorites'
		},
		{
			path: '/my/followers',
			src: UserGroup,
			text: 'followers'
		},
		{
			path: '/my/following',
			src: UserPlus,
			text: 'following'
		},
		{
			path: '/my/blacklist',
			src: NoSymbol,
			text: 'blocked'
		}
	];
</script>
{#each links as { path, src, text, exact } (path)}
	<SideNavLink href={localePath(path)} {exact}>
		<Icon {src} theme='solid' class='h-6 w-6 ' aria-hidden='true' />{$t('global.my_links.' + text)}
	</SideNavLink>
{/each}
