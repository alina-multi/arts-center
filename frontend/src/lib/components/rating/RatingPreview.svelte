<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChatBubbleOvalLeft, Heart } from '@steeze-ui/heroicons';

	export let rating: number, comments: number;
</script>

<div class="flex items-center gap-2 overflow-hidden text-sm xl:text-[12px] p-1 dark:text-zinc-100  font-medium">
	{#if rating > 0}<span class="inline-flex items-center gap-1">
			<Icon src={Heart}  class=" w-5 h-5 md:w-3.5 md:h-3.5   stroke-2 " />
			<span>{rating}</span>
		</span>
	{/if}
	{#if comments > 0}
		<span class="inline-flex items-center gap-1">
			<Icon src={ChatBubbleOvalLeft}  class=" w-5 h-5 md:w-3.5 md:h-3.5 stroke-2 " />
			<span>{comments}</span>
		</span>
	{/if}
</div>
