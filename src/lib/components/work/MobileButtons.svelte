<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import {
		Heart,
		ShoppingCart,
		ChatBubbleLeftRight,
		BookmarkSlash,
		Bookmark
	} from '@steeze-ui/heroicons';
</script>

<div
	class="flex justify-between  text-sm sm:text-sm text-gray-700 items-center md:hidden border dark:border-transparent bg-gray-100 dark:bg-transparent px-4 py-2 dark:text-gray-300 "
>
	<button
		class="flex items-center  rounded-md px-3  py-1 hover:shadow-md gap-2 bg-white dark:bg-gray-900 dark:border dark:border-gray-600"
	>
		<span class="hidden min-[500px]:block ">Like</span>
		<Icon src={Heart} class="w-6 h-6  dark:stroke-gray-300" />
	</button>
	<button
		class="flex items-center  rounded-md px-3 py-1 hover:shadow-md gap-2 bg-white dark:bg-gray-900 dark:border dark:border-gray-600"
	>
		<span class="hidden min-[500px]:block ">Comment</span>
		<Icon src={ChatBubbleLeftRight} class="w-6 h-6 dark:stroke-gray-300" />
	</button>
	<button
		class="flex items-center  rounded-md px-3 py-1 hover:shadow-md gap-2 bg-white dark:bg-gray-900 dark:border dark:border-gray-600"
	>
		<span class="hidden min-[500px]:block ">Save</span>
		<Icon src={Bookmark} class="w-6 h-6 dark:stroke-gray-300" />
	</button>
	<button
		class=" flex items-center  rounded-md px-3 py-1 hover:shadow-md gap-2 bg-white dark:bg-gray-900 dark:border dark:border-gray-600"
	>
		<span class="hidden min-[500px]:block dark:stroke-gray-300"> Add to cart</span>
		<Icon src={ShoppingCart} class="w-6 h-6 " />
	</button>
</div>
