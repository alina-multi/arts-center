<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import {
		Bookmark,
		BookmarkSlash,
		ChatBubbleLeftRight,
		CheckCircle,
		HandThumbUp,
		PlusCircle,
		Share,
		ShoppingCart
	} from '@steeze-ui/heroicons';

	export let type;
	export let isAddedToCart = true;
	export let isLiked = true;
	export let isBookmarked = false;
</script>

{#if type === 'cart'}
	<button
		class=" relative border p-2 rounded-full hover:shadow-md hover:text-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900 dark:hover:text-gray-100  dark:hover:border-gray-400"
	>
		<Icon src={ShoppingCart} theme="solid" class="w-6 h-6  " />
		<div class="absolute -top-[6px] -right-[5px] ">
			{#if isAddedToCart}
				<Icon
					src={CheckCircle}
					theme="solid"
					class=" w-5 h-5 rounded-full stroke-white fill-emerald-700"
				/>
			{:else}
				<Icon
					src={PlusCircle}
					theme="solid"
					class=" w-5 h-5 bg rounded-full stroke-white fill-amber-600"
				/>
			{/if}
		</div>
	</button>
{/if}

{#if type === 'like'}
	<button
		class=" border p-2 rounded-full  hover:text-sky-700 hover:shadow-md  hover:bg-gray-50 dark:hover:bg-gray-900  dark:hover:border-gray-400 {isLiked
			? 'text-sky-700'
			: 'text-gray-500'}"
	>
		<Icon src={HandThumbUp} theme="solid" class="w-6 h-6 " />
	</button>
{/if}

{#if type === 'bookmark'}
	<button
		class="  border p-2 rounded-full hover:shadow-md  hover:text-rose-800 hover:bg-gray-50 dark:hover:bg-gray-900  dark:hover:border-gray-400 "
	>
		{#if isBookmarked}
			<Icon src={Bookmark} theme="solid" class="w-6 h-6" />
		{:else}
			<Icon src={BookmarkSlash} theme="solid" class="w-6 h-6" />
		{/if}
	</button>
{/if}

{#if type === 'comment'}
	<button
		class="  border p-2 rounded-full  hover:shadow-md  hover:text-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 dark:hover:text-gray-100  dark:hover:border-gray-400"
	>
		<Icon src={ChatBubbleLeftRight} theme="solid" class="w-6 h-6" />
	</button>
{/if}

{#if type === 'share'}
	<button
		class="  border p-2 rounded-full  hover:shadow-md  hover:text-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 dark:hover:text-gray-100  dark:hover:border-gray-400"
	>
		<Icon src={Share} theme="solid" class="w-6 h-6" />
	</button>
{/if}
