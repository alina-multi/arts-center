<script lang="ts">
    import { localePath, t } from '$lib/translations';
    import { page } from '$app/stores';
</script>

<a
			href={localePath(`/login?redirect=${$page.url.pathname}`)}
			class=" text-sm inline-flex border rounded-full px-3 py-1 border-black text-black dark:text-white dark:border-zinc-500 dark:bg-zinc-800 hover:border-amber-600 hover:text-amber-600 dark:hover:bg-zinc-900 dark:hover:text-amber-500 dark:hover:border-amber-500 hover:shadow-xl  shadow-md"
			>LOGIN</a
		>