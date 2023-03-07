<script lang="ts">
	import { QuillDeltaToHtmlConverter } from 'quill-delta-to-html';
	export let block: any;
	$: html = new QuillDeltaToHtmlConverter(block?.data?.ops, {}).convert();
</script>
<div class="py-1 text-base md:text-lg">
{@html html}
</div>
