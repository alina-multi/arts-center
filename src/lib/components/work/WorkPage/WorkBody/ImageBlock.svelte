<script lang="ts">
	export let block: any;
	$: src = block?.images[0]?.src;
	$: srcset = block?.images[0]?.srcset;
	console.log(block);
</script>


  <div class="flex justify-between ">
  <img class=' h-full w-full ' src={src} srcset={srcset} />
 
</div>


