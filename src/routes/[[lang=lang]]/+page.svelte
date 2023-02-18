<script lang="ts">
	import type { PageData } from './$types';
	import { t } from '$lib/translations';
	BigInt.prototype.toJSON = function () {
		return this.toString();
	};
	export let data: PageData;
</script>

<h1>{$t('gallery.title')}</h1>
<p>{@html $t('gallery.text')}</p>

{JSON.stringify(data.gallery)}
