<script lang="ts">
	import { localePath } from '$lib/translations';
	import type { User as UserType } from '$lib/interfaces/User';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Pencil } from '@steeze-ui/heroicons';
	import { getContext } from 'svelte';

	const t = getContext('t');
	const locale = getContext('locale');

	export let user: UserType;
	export let size = 'h-20 w-20';
</script>

<a
	href={localePath($locale, '/my/photo')}
	class="relative inline-flex items-center gap-2 text-transparent hover:text-zinc-900 font-semibold"
>
	<Avatar {user} {size} />
	<div
		class="absolute h-full w-full flex justify-center gap-1 font-medium flex-col text-sm items-center rounded-full align-middle hover:bg-gray-50/50"
	>
		<Icon src={Pencil} class="w-5 h-5 inline-block" />
		<span>
			{$t('global.buttons.edit')}
		</span>
	</div>
</a>
