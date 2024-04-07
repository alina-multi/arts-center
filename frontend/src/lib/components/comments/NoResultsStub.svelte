<script>
	import cat from '$lib/images/cat-icons.svg';
	import { getContext } from 'svelte';

	const t = getContext('t');
</script>

<div
	class="mt-3 border-b flex pb-9 justify-between xl:justify-start items-end text-sm gap-6 border-zinc-200 dark:border-zinc-800 dark:bg-zinc-900 dark:p-3 sm:dark:p-6 dark:border"
>
	<div class="flex flex-col text-gray-600 dark:text-zinc-100">
		<span class="leading-5"> {$t('global.comment.stub.no_comments')}</span>
		<span class="leading-5"> {$t('global.comment.stub.be_first')}</span>
	</div>

	<svg class="h-16 w-24 fill-zinc-600 dark:fill-zinc-100 flex-none">
		<use href="{cat}#icon-cat-sleeping" />
	</svg>
</div>
