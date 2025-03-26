<script lang="ts">
	import { getContext } from 'svelte';
	import LoginLink from '../nav/LoginLink.svelte';
	import RegisterButton from '$lib/components/atoms/buttons/RegisterButton.svelte';

	const t = getContext('t');
</script>

<div
	class="bg-zinc-900 max-sm:px-6 p-9 dark:bg-zinc-900 py-12 dark:border-zinc-800 max-xl:mt-5 w-full space-y-3 max-sm:pt-9 dark:p-6"
>
	<p class="text-2xl font-semibold text-white">
		{$t('global.not_logged_in.title')}
	</p>
	<div class="dark:text-zinc-100 text-sm font-semibold text-white">
		<p>
			{$t('global.not_logged_in.p1')}
		</p>
	</div>

	<div class="  md:w-1/2 gap-6 pt-3 grid grid-cols-2 font-medium">
		<LoginLink styles=" bg-white border dark:border " />
		<RegisterButton
			styles="border-zinc-800 bg-white  hover:text-white font-medium dark:border-zinc-500"
		/>
	</div>
</div>
