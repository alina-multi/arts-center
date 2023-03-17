<script lang="ts">
	export let block: any;
	$: src = block?.images[0]?.src;
	$: srcset = block?.images[0]?.srcset;
</script>

<img class=" h-full w-full rounded-sm" {src} {srcset} />
