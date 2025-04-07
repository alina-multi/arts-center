<script>
	import cat from '$lib/images/cat-icons.svg';
	import { getContext } from 'svelte';

	const t = getContext('t');
</script>

<div
	class="  max-md:flex-col-reverse max-md:items-center py-6 md:px-4 flex text-lg md:justify-between items-end gap-6 max-xs:p-6 border-zinc-200 dark:border-zinc-800 dark:bg-zinc-900 dark:border"
>
	<div class="flex flex-col max-md:items-center max-md:justify-center gap-3 dark:text-zinc-100">
		<p class="leading-5">{$t('global.comment.stub.no_comments')}</p>
		<p class="leading-5 text-center">{$t('global.comment.stub.be_first')}</p>
	</div>

	<svg class="max-md:pl-3 h-28 w-40 fill-zinc-800 dark:fill-zinc-100 flex-none">
		<use href="{cat}#icon-cat-sleeping" />
	</svg>
</div>
