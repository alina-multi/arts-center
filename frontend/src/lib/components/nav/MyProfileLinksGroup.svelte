<script>
	import { localePath } from '$lib/translations';
	import SideNavLink from '$lib/components/nav/side/SideNavLink.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import {
		ArrowUpOnSquareStack,
		Bell,
		Bookmark,
		Camera,
		CurrencyDollar,
		FolderOpen,
		NoSymbol,
		PencilSquare,
		PlusCircle,
		RectangleStack,
		UserGroup,
		UserPlus
	} from '@steeze-ui/heroicons';
	import { user } from '$lib/stores/auth';
	import { getContext } from 'svelte';

	const t = getContext('t');
	const locale = getContext('locale');

	let folders = $user?.favorites?.folders;
	const favorites_href =
		folders.length === 0 || folders.length > 1 ? '/my/favorites' : '/my/favorites/' + folders[0].id;
	const links = [
		{
			path: '/my/notifications',
			src: Bell,
			text: 'notifications',
			badge: $user.unread,
			visibility: 'sm:hidden'
		},
		{
			path: '/my/profile',
			src: PencilSquare,
			text: 'edit_profile'
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
			text: 'add_post',
			show: $user.role > 0
		},
		{
			path: '/my/post',
			src: RectangleStack,
			text: 'posts',
			exact: true,
			show: $user.role > 0
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

{#each links as { path, src, text, exact, show, badge, visibility } (path)}
	{#if show === undefined || show}
		<div class=" {visibility} ">
			<SideNavLink href={localePath($locale, path)} {exact}>
				<div class="flex items-center justify-between w-full">
					<div class="flex items-center gap-3">
						<Icon {src} class="h-6 w-6 stroke-1" aria-hidden="true" />{$t(
							'global.my_links.' + text
						)}
					</div>
					{#if badge}
						<span
							class=" bg-red-500 text-white text-xs font-medium rounded-full px-1 min-w-4 h-4 leading-3 flex justify-center items-center"
						>
							{badge}
						</span>
					{/if}
				</div>
			</SideNavLink>
		</div>
	{/if}
{/each}
