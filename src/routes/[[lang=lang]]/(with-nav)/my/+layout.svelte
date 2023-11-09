<script>
	import SideMenu from '$lib/components/nav/side/SideMenu.svelte';
	import SideNav from '$lib/components/nav/side/SideNav.svelte';
	import AvatarEditLink from '$lib/components/user/AvatarEditLink.svelte';
	import MyProfileLinksGroup from '$lib/components/nav/MyProfileLinksGroup.svelte';
	import { user } from '$lib/stores/auth';
	import Hint from '$lib/components/atoms/Hint.svelte';
	import { t, localePath } from '$lib/translations';
</script>

{#if $user}
	<SideMenu style="hidden xl:block ">
		{#if !$user.email_verified_at}
			<Hint type="warning">{$t('my.hint.email')}</Hint>
		{/if}
		{#if !$user.approved_at}
			<Hint type="danger">{$t('my.hint.approved')}</Hint>
		{/if}
		<slot />
		<div slot="nav" class="text-sm ">
			<div class="bg-zinc-700 dark:bg-zinc-800  h-20 w-full rounded-t-sm shadow-lg " />
			<div class="text-center -mt-10 pb-3 border-b dark:border-b dark:border-zinc-800 flex flex-col justify-center items-center gap-3">
				<AvatarEditLink user={$user} />
				<a
					href={localePath(`/${$user.username}`)}
					class=" inline-flex items-center gap-2 hover:underline flex-1 font-semibold text-base text-black dark:text-white hover:text-gray-700 dark:hover:text-zinc-300"
				>
					{$user.name}
				</a>
			</div>

			<SideNav>
				<MyProfileLinksGroup />
			</SideNav>
		</div>
	</SideMenu>
{/if}
