<script lang="ts">
	export let block: any;
</script>

<h3>This is grid block</h3>
<div>
	{#each block.images as image}
		<img src={image.src} srcset={image.srcset} />
	{/each}
</div>
