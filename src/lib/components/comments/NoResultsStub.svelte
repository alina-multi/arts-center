<script>
	import {t} from '$lib/translations';
   import cat from '$lib/images/cat-icons.svg';
</script>
<div class="flex items-end justify-center gap-3">
	<div class="flex flex-col items-end  text-gray-500 dark:text-zinc-400 gap-1">
		<span > {$t('global.comment.stub.no_comments')}</span>
		<span class="leading-4"> {$t('global.comment.stub.be_first')}</span>
	</div>

	<svg class="h-16 w-24 fill-zinc-600 dark:fill-zinc-300">
		<use href="{cat}#icon-cat-sleeping" />
	</svg>
</div>