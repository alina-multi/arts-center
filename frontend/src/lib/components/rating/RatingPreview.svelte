<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChatBubbleOvalLeft, Heart } from '@steeze-ui/heroicons';

	export let rating: number, comments: number;
</script>

<div
	class="flex items-center gap-1 sm:gap-2 overflow-hidden text-xs sm:text-sm xl:text-[12px] p-1 dark:text-zinc-100 font-medium"
>
	{#if rating > 0}<span class="inline-flex items-center gap-1">
			<Icon src={Heart} class="w-4 h-4 sm:w-5 sm:h-5 md:w-3.5 md:h-3.5 sm:stroke-2" />
			<span>{rating}</span>
		</span>
	{/if}
	{#if comments > 0}
		<span class="inline-flex items-center gap-1">
			<Icon src={ChatBubbleOvalLeft} class=" w-4 h-4 sm:w-5 sm:h-5 md:w-3.5 md:h-3.5 sm:stroke-2 " />
			<span>{comments}</span>
		</span>
	{/if}
</div>
