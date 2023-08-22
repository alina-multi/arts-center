<script lang="ts">
	import { localePath } from '$lib/translations';
	import logo from '$lib/images/logo.svg';
</script>

<a
	href={localePath('/')}
	class="text-amber-700 inline-flex items-center pt-1 focus-visible:outline-none"
>
	<svg class=" h-20 w-[10rem] dark:fill-white dark:stroke-white">
		<use href="{logo}#logo" />
	</svg>
</a>
