<script lang="ts">
    	import cat from '$lib/images/cat-icons.svg';
        import {t} from '$lib/translations';
    </script>

<div class="p-6 flex flex-col items-center">
    <div class="w-24">
        <svg class="h-24 w-24 text-gray-400 dark:fill-zinc-400">
            <use href="{cat}#icon-cat-with-ball" />
        </svg>
    </div>
    <p class="mt-4 text-sm text-black dark:text-zinc-400">
        {$t('global.search.stub_nothing')}
    </p>
</div>