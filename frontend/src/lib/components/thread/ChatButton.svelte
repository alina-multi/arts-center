<script lang="ts">
	import { user as currentUser, isUserLoading } from '$lib/stores/auth';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChatBubbleOvalLeftEllipsis } from '@steeze-ui/heroicons';
	import { localePath } from '$lib/translations';
	import { getContext } from 'svelte';
	const locale = getContext('locale');
</script>

{#if !$isUserLoading}
	{#if $currentUser }
		<a
			href={localePath($locale, `/my/thread`)}
			class="relative hover:bg-gray-100 dark:hover:bg-zinc-700 flex items-center justify-center rounded-full p-1 transition-all"
		>
			<Icon src={ChatBubbleOvalLeftEllipsis} class="h-8 w-8 stroke-1" />
			{#if $currentUser.unread_messages > 0}
				<span
					class="absolute right-1 top-1 bg-red-500 text-white text-xs rounded-full leading-3 px-1 py-0.5"
				>
					{$currentUser.unread_messages}
				</span>
			{/if}
		</a>
	{/if}
{/if}
