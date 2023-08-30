<script lang="ts">
	import { localePath, t } from '$lib/translations';
	import ModalWindow from '$lib/components/atoms/ModalWindow.svelte';
	import TopNavLink from '$lib/components//nav/TopNavLink.svelte';
	import { page } from '$app/stores';

	export let open: boolean;
</script>

<ModalWindow bind:open>
	<p class="text-gray-700 dark:text-gray-300 text-center text-lg border-b pb-3 font-semibold">
		{$t('global.authModal.title')}
	</p>
	<div class="flex gap-3 justify-center items-center py-3">
		<TopNavLink href={localePath('/login?redirect=' + $page.url.pathname)}
			>{$t('global.menu.not_logged_in.for_follow')}</TopNavLink
		>
		<span>or</span>
		<TopNavLink href={localePath('/register')}>{$t('global.menu.register')}</TopNavLink>
	</div>
</ModalWindow>
