<script>
	import {t} from '$lib/translations';
	import cat from '$lib/images/cat-icons.svg';
	import { user } from '$lib/stores/auth';


</script>
<div class="{$user ? " rounded-sm border-transparent" :"mt-6"} flex items-end justify-center gap-3 border bg-zinc-50 border-zinc-100   dark:border-zinc-800 dark:bg-zinc-900 pt-6 pb-12 rounded-b-sm">
	<div class="flex flex-col items-end  text-gray-500 dark:text-zinc-100 gap-1">
		<span > {$t('global.comment.stub.no_comments')}</span>
		<span class="leading-4"> {$t('global.comment.stub.be_first')}</span>
	</div>

	<svg class="h-16 w-24 fill-zinc-600 dark:fill-zinc-100">
		<use href="{cat}#icon-cat-sleeping" />
	</svg>
</div>