<script>
	import SideMenu from '$lib/components/nav/side/SideMenu.svelte';
	import SideNav from '$lib/components/nav/side/SideNav.svelte';
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import MyProfileLinksGroup from '$lib/components/nav/MyProfileLinksGroup.svelte';
	import { user } from '$lib/stores/auth';
	import Hint from '$lib/components/atoms/Hint.svelte';
	import { t } from '$lib/translations'
</script>

{#if $user}
	<SideMenu style='hidden xl:block '>
		{#if !$user.email_verified_at}
			<Hint type='warning'>{$t('my.hint.email')}</Hint>
		{/if}
		{#if !$user.approved_at}
			<Hint type='danger'>{$t('my.hint.approved')}</Hint>
		{/if}
		<slot />
		<div slot='nav'>
			<SideNav>
				<li class='mx-6 text-left'>
					<AvatarLink user={$user} size='h-12 w-12' withName nameStyles={'font-semibold text-sm'} />
				</li>
				<MyProfileLinksGroup />
			</SideNav>
		</div>
	</SideMenu>
{/if}