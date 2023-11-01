<script lang='ts'>
	import { localePath } from '$lib/translations';
	import type { User as UserType } from '$lib/interfaces/User';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Pencil } from '@steeze-ui/heroicons';
	import { t } from '$lib/translations';

	export let user: UserType;
</script>

<a
	href={localePath('/my/avatar')}
	class='relative inline-flex items-center gap-2 text-transparent hover:text-gray-700'
>
	<Avatar {user} size='h-20 w-20' />
	<div class='absolute h-full flex justify-center items-center rounded-full align-middle hover:bg-gray-50/50'>
		<div>
			<Icon src={Pencil} class='w-4 h-4 inline-block' />
			{$t('global.buttons.edit')}
		</div>
	</div>
</a>