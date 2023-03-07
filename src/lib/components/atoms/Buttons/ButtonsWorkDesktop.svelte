<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import {
		ShoppingCart,
		ChatBubbleLeftRight,
		Heart,
		HandThumbUp,
		Bookmark,
        CheckCircle,
        Share,
        PlusCircle,

	} from '@steeze-ui/heroicons';
export let type;
</script>




<div class="flex flex-col gap-3 text-gray-400 dark:text-gray-500 ">
	{#if type === 'cart'}
    <button
		class=" relative border p-2 rounded-md hover:shadow-md hover:text-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900 dark:hover:text-gray-100  dark:hover:border-gray-400"
	>
		<Icon src={ShoppingCart} theme='solid' class="w-6 h-6  " />
    
    <div class="absolute -top-[6px] -right-[5px] "> 
        <Icon src={PlusCircle} theme='solid' class=" w-5 h-5 bg rounded-md stroke-white fill-amber-600" />
    </div> 
    <!-- <div class="absolute -top-[10px] -right-[8px] p-1 "> 
        <Icon src={CheckCircle} theme='solid' class=" w-5 h-5 bg rounded-full stroke-white fill-emerald-800" />
    </div>  -->
    </button>
    {/if}

    {#if type === 'like'}
	<button class="  border p-2 rounded-md  hover:text-sky-700 hover:shadow-md  hover:bg-gray-50 dark:hover:bg-gray-900  dark:hover:border-gray-400">
		<Icon src={HandThumbUp} theme='solid' class="w-6 h-6 " />
	</button>
    {/if}

    {#if type === 'bookmark'}
	<button class="  border p-2 rounded-md hover:shadow-md  hover:text-rose-800 hover:bg-gray-50 dark:hover:bg-gray-900  dark:hover:border-gray-400">
		<Icon src={Bookmark} theme='solid' class="w-6 h-6" />
	</button>
    {/if}

    {#if type === 'comment'}

	<button class="  border p-2 rounded-md  hover:shadow-md  hover:text-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 dark:hover:text-gray-100  dark:hover:border-gray-400">
		<Icon src={ChatBubbleLeftRight}  theme='solid'class="w-6 h-6" />
	</button>
    {/if}

    {#if type === 'share'}
    <button class="  border p-2 rounded-md  hover:shadow-md  hover:text-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 dark:hover:text-gray-100  dark:hover:border-gray-400">
        <Icon src={Share}  theme='solid'class="w-6 h-6" />
    </button>
    {/if}

 
</div>