<script lang="ts">
	import ModalWindow from '$lib/components/atoms/ModalWindow.svelte';
	import { getContext } from 'svelte';
	import AuthPage from '../auth/AuthPage.svelte';
	import { page } from '$app/stores';
	import BeforeNavigateLayout from './BeforeNavigateLayout.svelte';

	const t = getContext('t');

</script>

<BeforeNavigateLayout keysToInclude={['form', ]}  route={'/[[lang=lang]]/(auth)/login'} stateName={'auth'}>
	<ModalWindow
		on:close={() => history.back()}
		open={true}
		class="px-3  max-xs:h-screen md:w-4/5 lg:w-2/3 xs:my-12 xl:w-1/2 2xl:w-2/5 2xl:pb-16  xs:pb-12 sm:bg-zinc-50 max-xs:rounded-md max-md:w-full "
		closeButtonAddStyle="max-xs:bg-white xs:text-white max-xs:dark:bg-black"
	>
		<AuthPage {...$page.state.auth} />
	</ModalWindow>

</BeforeNavigateLayout>