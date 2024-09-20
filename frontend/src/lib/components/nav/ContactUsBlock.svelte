<script>
	import { getContext } from 'svelte';

	const t = getContext('t');
</script>

<h2 class="text-2xl my-5">{$t(`global.contact.h1`)}</h2>
<p>{$t(`global.contact.p1`)}</p>
<!-- <p>{$t(`global.contact.legal_name`)}</p> -->
<ul class="list-disc list-outside pl-9">
	<li>{$t(`global.contact.email`)} <a href="mailto:info@arts.center">info@arts.center</a></li>
</ul>
