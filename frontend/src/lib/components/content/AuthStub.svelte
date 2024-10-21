<script lang="ts">
	import { getContext } from 'svelte';
	import LoginLink from '../nav/LoginLink.svelte';
	import { localePath } from '$lib/translations';
	import RegisterButton from '$lib/components/atoms/buttons/RegisterButton.svelte';

	const t = getContext('t');
	const locale = getContext('locale');
</script>

<div
	class=" dark:xl:p-9 dark:bg-zinc-900 dark:border dark:border-zinc-800 max-xl:mt-5 w-full space-y-3 max-sm:pt-9 dark:p-6"
>
	<p class="text-2xl font-semibold">
		{$t('global.not_logged_in.title')}
	</p>
	<div class="dark:text-zinc-100">
		<p>
			{$t('global.not_logged_in.p1')}
		</p>
	</div>

	<div class="   gap-6 pt-3 grid grid-cols-2 font-medium">
		<LoginLink styles=" bg-white border dark:border  " />
		<RegisterButton />
	</div>
</div>
