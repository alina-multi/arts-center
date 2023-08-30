<script lang="ts">
	import { t } from '$lib/translations';
	let clazz = '';
	export { clazz as class };
	export let type: 'submit' | 'reset' | 'button' = 'submit';
</script>

<button
	on:click
	{type}
	class="{clazz} rounded-full px-3 py-2 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
>
	<slot>{$t('my.buttons.save')}</slot>
</button>
