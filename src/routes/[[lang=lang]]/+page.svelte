<script lang="ts">
	import type { PageData } from './$types';
	import { t } from '$lib/translations';
	import Gallery from '$lib/components/work/Gallery.svelte';
	export let data: PageData;
  BigInt.prototype.toJSON = function() { return this.toString() }
</script>

<Gallery gallery={data.gallery} />

{JSON.stringify(data.categories)}
