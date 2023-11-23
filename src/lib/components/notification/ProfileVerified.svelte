<script lang='ts'>
	import { t } from '$lib/translations';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { DocumentCheck } from '@steeze-ui/heroicons';

	export let notification;
</script>

<span class='flex gap-3 items-center text-sm w-full py-3'>
	<span class='p-1.5 rounded-full bg-green-500'>
		<Icon src={DocumentCheck} theme='solid' class='w-5 h-5 text-white' />
	</span>
	<div class='flex flex-wrap items-center'>
		<span> {$t(`global.notifications.profile_verified`)}</span>
	</div>
</span>
