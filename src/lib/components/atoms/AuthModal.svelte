<script lang="ts">
	import {t } from '$lib/translations';
	import ModalWindow from '$lib/components/atoms/ModalWindow.svelte';

	import LoginLink from '../nav/LoginLink.svelte';

	export let open: boolean, type;
</script>

<ModalWindow bind:open>
	<p class="text-gray-700 dark:text-gray-300  text- text-center font-semibold pb-3">
		{$t('global.not_logged_in.login_to')} {type}
	</p>
	<div class="flex gap-3 justify-center items-center ">
		<LoginLink  primary/>
	</div>
</ModalWindow>
