<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChatBubbleLeftRight, Heart } from '@steeze-ui/heroicons';

	export let rating: number, comments: number;
</script>

<div class="flex items-center gap-2 overflow-hidden sm:text-sm text-xs  font-medium p-1 dark:text-zinc-100">
	{#if rating > 0}<span class="inline-flex items-center gap-1">
			<Icon src={Heart} class=" w-4 h-4 sm:w-6 sm:h-6 " />
			<span>{rating.toLocaleString('ru-RU')}</span>
		</span>
	{/if}
	{#if comments > 0}
		<span class="inline-flex items-center gap-1">
			<Icon src={ChatBubbleLeftRight} class=" w-4 h-4 sm:w-6 sm:h-6" />
			<span>{comments.toLocaleString('ru-RU')}</span>
		</span>
	{/if}
</div>
