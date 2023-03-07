<script lang="ts">
import { Icon } from '@steeze-ui/svelte-icon';
import {UserCircle, Heart} from '@steeze-ui/heroicons';
export let work;
</script> 
 

<div> 
    <!-- <button class="hidden md:flex items-center  px-4 py-2 rounded-md   bg-white text-gray-600 dark:bg-gray-900 dark:border-gray-500 dark:text-gray-100 gap-2 "> 
<Icon src={Heart} class="w-7 h-7" />
</button> -->
</div>

<div class="dark:text-gray-400 text-sm">
<div class="flex gap-3 items-center">
 <div>Comments: 45678</div>
<div class="flex items-center gap-2">
    <div class="hover:underline ">
        <span class="">Liked by</span>
        {work.rating.toLocaleString('ru-RU')}
    </div>

    <div class="flex -space-x-3">
        <Icon
            src={UserCircle}
            theme="solid"
            class="h-8 w-8 md:h-10 md:w-10 rounded-full fill-gray-300  border-gray-400 bg-white dark:bg-gray-900 dark:fill-gray-400"
        />
        <Icon
            src={UserCircle}
            theme="solid"
            class="h-8 w-8 md:h-10 md:w-10 rounded-full fill-gray-300    border-gray-400 bg-white dark:bg-gray-900 dark:fill-gray-400"
        />
        <Icon
            src={UserCircle}
            theme="solid"
            class="h-8 w-8 md:h-10 md:w-10 rounded-full fill-gray-300   border-gray-400 bg-white dark:bg-gray-900 dark:fill-gray-400"
        />
    </div>
</div>
</div>

</div>