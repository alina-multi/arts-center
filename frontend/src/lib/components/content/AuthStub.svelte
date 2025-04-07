<script lang="ts">
	import { getContext } from 'svelte';
	import LoginLink from '../nav/LoginLink.svelte';
	import RegisterButton from '$lib/components/atoms/buttons/RegisterButton.svelte';
	import Icon4 from '$lib/components/static_pages/icons/Icon4.svelte';
	const t = getContext('t');
</script>

<div
	class=" xl:grid xl:grid-cols-[auto_30%] space-y-9 bg-zinc-900 max-sm:px-6 dark:bg-zinc-900 p-12 dark:border-zinc-800 w-full max-sm:pt-9"
>
	<div class="space-y-6">
		<Icon4 class="w-20 h-20 fill-amber-600 xl:hidden" />
		<p class="text-2xl font-semibold text-white max-xl:text-center">
			{$t('global.not_logged_in.title')}
		</p>
		<div class="dark:text-zinc-100 text-white">
			<p>
				{$t('global.not_logged_in.p1')}
			</p>
			<p>
				{$t('global.not_logged_in.p2')}
			</p>
		</div>
	</div>

	<div
		class=" md:grid xl:grid-rows-2 xl:pl-6 xl:gap-6 font-medium flex flex-col gap-6 md:max-xl:grid-cols-2"
	>
		<LoginLink
			styles=" py-3 px-6 tracking-widest lg:text-lg  border-zinc-300 bg-zinc-800 text-white w-full hover:bg-zinc-700 "
		/>
		<RegisterButton
			styles="py-3 px-6 tracking-widest lg:text-lg  border-zinc-300 dark:border-zinc-500 bg-zinc-800 text-white w-full hover:bg-zinc-700 "
		/>
	</div>
</div>
