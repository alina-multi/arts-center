<script>
	import { t } from '$lib/translations';
  import Filters from "$lib/components/nav/Filters.svelte";
</script>

<Filters label="test" options={[]} filters={[]}/>
<h1>{$t('users.title')}</h1>
<p>{@html $t('users.text')}</p>
