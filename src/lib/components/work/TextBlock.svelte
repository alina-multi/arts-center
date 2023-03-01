<script lang="ts">
  import { QuillDeltaToHtmlConverter } from 'quill-delta-to-html';
  export let block: any
  $: html = new QuillDeltaToHtmlConverter(block?.data?.ops, {}).convert();
</script>
<h3>This is text block</h3>
<div>
{@html html}
</div>