<script lang="ts">
	import {t } from '$lib/translations';
	import ModalWindow from '$lib/components/atoms/ModalWindow.svelte';

	import LoginLink from '../nav/LoginLink.svelte';

	export let open: boolean, type;
</script>

<ModalWindow bind:open class=" p-9 xl:p-12  xl:w-4/12  max-sm:mx-6 sm:w-3/4 md:w-2/3 lg:w-1/2 rounded-sm my-24">
	<p class="text-gray-700 dark:text-gray-300  text-xl text-center font-semibold pb-6">
		{$t('global.not_logged_in.login_to')} {type}
	</p>
	<div class="flex gap-3 justify-center items-center ">
		<LoginLink  primary/>
	</div>
</ModalWindow>
