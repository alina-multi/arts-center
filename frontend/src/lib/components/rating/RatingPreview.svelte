<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChatBubbleOvalLeft, Heart } from '@steeze-ui/heroicons';

	export let rating: number, comments: number;
</script>

<div class="flex items-center gap-2 overflow-hidden text-sm xl:text-xs p-1 dark:text-zinc-100">
	{#if rating > 0}<span class="inline-flex items-center gap-[0.5]">
			<Icon src={Heart} class=" w-5 h-5 md:w-4 md:h-4   stroke-1" />
			<span>{rating}</span>
		</span>
	{/if}
	{#if comments > 0}
		<span class="inline-flex items-center gap-[0.5]">
			<Icon src={ChatBubbleOvalLeft} class=" w-5 h-5 md:w-4 md:h-4 stroke-1" />
			<span>{comments}</span>
		</span>
	{/if}
</div>
