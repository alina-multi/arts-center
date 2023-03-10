<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { UserCircle } from '@steeze-ui/heroicons';

	export let work;
</script>

<div class="dark:text-gray-400 text-sm">
	<div class="flex gap-3 items-center">
		<div>Comments: {work.comments}</div>
		<div class="flex items-center gap-2">
			<div class="hover:underline ">
				<span class="">Liked by</span>
				{work.rating}
			</div>

			<div class="flex -space-x-3">
				<Icon
					src={UserCircle}
					theme="solid"
					class="h-8 w-8 md:h-10 md:w-10 rounded-full fill-gray-300 border-gray-400 bg-white dark:bg-gray-900 dark:fill-gray-400"
				/>
				<Icon
					src={UserCircle}
					theme="solid"
					class="h-8 w-8 md:h-10 md:w-10 rounded-full fill-gray-300 border-gray-400 bg-white dark:bg-gray-900 dark:fill-gray-400"
				/>
				<Icon
					src={UserCircle}
					theme="solid"
					class="h-8 w-8 md:h-10 md:w-10 rounded-full fill-gray-300 border-gray-400 bg-white dark:bg-gray-900 dark:fill-gray-400"
				/>
			</div>
		</div>
	</div>
</div>
