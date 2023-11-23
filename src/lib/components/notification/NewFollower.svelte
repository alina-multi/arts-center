<script lang="ts">
	import type { NewFollower } from '$lib/interfaces/Notification';
	import { localePath,t } from '$lib/translations';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { UserPlus } from '@steeze-ui/heroicons';

	export let notification: NewFollower;
	let { username, name } = notification;
	let href = localePath(`/${username}`);
</script>

<a {href} class="flex gap-3 items-center text-sm w-full py-3">
	<span class="p-1.5 rounded-full bg-blue-500">
		<Icon src={UserPlus} theme="solid" class="w-5 h-5 text-white" />
	</span>
	<div class="flex flex-wrap items-center">
		<span class="font-semibold mr-3 hover:underline">{name}</span>
		<span class="mr-1"> {$t(`global.notifications.started_following_you`)}</span>
	</div>
</a>
