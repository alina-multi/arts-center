<script lang="ts">
    import { Icon } from '@steeze-ui/svelte-icon';
	import { User } from '@steeze-ui/heroicons';
	export let photo ;
   
    let images = [];
    let src = '';
    
   /// move to utils
	const imagesMap = (sources) => {
		let jpeg = {
			type: 'jpeg',
			srcset: ''
		};

		let webp = {
			type: 'webp',
			srcset: ''
		};

		sources.forEach((source) => {
			if (source.src.includes('jpeg')) {
				jpeg.srcset += `${source.src} ${source.width}w, `;
			}
			if (source.src.includes('webp')) {
				webp.srcset += `${source.src} ${source.width}w, `;
			}
		});

		return [webp, jpeg];
	};
   /// move to utils
	const createDefaultSrc = (sources) => {
		let source = sources
			.filter((source) => source.src.includes('jpeg') || source.src.includes('png'))
			.reduce((prev, curr) => (prev.width < curr.width ? prev : curr));

		return source.src;
	};

if (photo) {
     images = imagesMap(photo.sources);
	 src = createDefaultSrc(photo.sources);

} 
</script>

{#if photo}
   <picture   >
    {#each images as image}
        <source srcset={image.srcset} type="image/{image.type}" />
    {/each}
    <img {src} alt=" username"  class="w-12 h-12 object-cover" />
</picture>

{:else}
    <Icon
        theme="solid"
        src={User}
        class="h-12 w-12 rounded-full fill-gray-300  p-[5px] border border-gray-300 dark:border-gray-700"
    />
{/if}  

