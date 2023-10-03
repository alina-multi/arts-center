<script lang="ts">
	import type { PageData } from './$types';
	import UserGallery from '$lib/components/user/UserGallery.svelte';
	export let data: PageData;
</script>

<UserGallery {...data}/>
