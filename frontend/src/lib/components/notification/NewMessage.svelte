<script lang="ts">
	import { localePath } from '$lib/translations';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Envelope } from '@steeze-ui/heroicons';
	import { getContext } from 'svelte';

	export let notification;

	const t = getContext('t');
	const locale = getContext('locale');

	let { user, thread_id } = notification;
	let href = localePath($locale, `/${thread_id}`);
</script>

<a
	href={localePath($locale, `/my/thread/${thread_id}`)}
	class="flex gap-3 items-center text-sm w-full py-3"
>
	<span class="p-1.5 rounded-full bg-red-500"
		><Icon src={Envelope} theme="solid" class="w-5 h-5 text-white" /></span
	>
	<div class="flex flex-wrap items-center">
		<a {href} class="font-semibold mr-1 hover:underline">{user.name}</a>

		<span class="text-sm">{$t(`global.notifications.new_message`)}</span>
		<span class="ml-3 p-1 font-semibold text-red-500 underline"
			>{$t(`global.notifications.go_to_message`)}
		</span>
	</div>
</a>
