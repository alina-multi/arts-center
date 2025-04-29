<script lang="ts">
	import { localePath } from '$lib/translations';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Envelope } from '@steeze-ui/heroicons';
	import { getContext } from 'svelte';
	import { invalidateAll } from '$app/navigation';

	export let notification;

	const t = getContext('t');
	const locale = getContext('locale');

	let { user, thread_id } = notification;
	let href = localePath($locale, `/${thread_id}`);
</script>

<a
	href={localePath($locale, `/my/thread/${thread_id}`)}
	on:click={()=>invalidateAll()}
	class="flex gap-3 items-center text-sm w-full py-3"
>
	<span class="p-1.5 rounded-full bg-red-500"
		><Icon src={Envelope} theme="solid" class="w-5 h-5 text-white" /></span
	>
	<div class="space-y-1">
		<span class="text-sm"> {$t('my.messages.newMessage_from')} </span>
		<a {href} class="font-semibold mr-1 hover:underline"> {user.name}</a>

		<div
			class="flex flex-col w-full max-w-[320px] leading-1.5 px-4 py-2 border-zinc-200 bg-zinc-100 dark:bg-zinc-600 rounded-e-xl rounded-es-xl"
		>
			<p class="text-sm font-medium">
				{notification?.message}
			</p>
		</div>
	</div>
</a>
