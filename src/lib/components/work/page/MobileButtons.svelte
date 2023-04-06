<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import {
		Bookmark,
		BookmarkSlash,
		ChatBubbleLeftRight,
		Heart,
		ShoppingCart
	} from '@steeze-ui/heroicons';

	export let type;
</script>

<button
	class="flex items-center  rounded-md px-3  py-1 hover:shadow-md gap-2 bg-white dark:bg-gray-900 dark:border dark:border-gray-600"
>
	{#if type === 'like'}
		<span class="hidden min-[500px]:block ">Like</span>
		<Icon src={Heart} class="w-6 h-6  dark:stroke-gray-300" />
	{/if}
	{#if type === 'comment'}
		<span class="hidden min-[500px]:block ">Comment</span>
		<Icon src={ChatBubbleLeftRight} class="w-6 h-6 dark:stroke-gray-300" />
	{/if}
	{#if type === 'bookmark'}
		<span class="hidden min-[500px]:block ">Bookmark</span>
		<Icon src={Bookmark} class="w-6 h-6 dark:stroke-gray-300" />
	{/if}
	{#if type === 'unbookmark'}
		<span class="hidden min-[500px]:block ">Unbookmark</span>
		<Icon src={BookmarkSlash} class="w-6 h-6 dark:stroke-gray-300" />
	{/if}
	{#if type === 'cart'}
		<span class="hidden min-[500px]:block ">Add to cart</span>
		<Icon src={ShoppingCart} class="w-6 h-6 dark:stroke-gray-300" />
	{/if}
</button>
