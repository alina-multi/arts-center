<script lang="ts">
  import type { Comment } from "$lib/interfaces/Comment";
  import { QuillDeltaToHtmlConverter } from 'quill-delta-to-html';
  import UserPreviewInline from "$lib/components/user/UserPreviewInline.svelte";

  export let comment: Comment
  $: html = new QuillDeltaToHtmlConverter(comment?.body?.ops, {}).convert();
</script>

<div class="flex space-x-4 text-sm text-gray-500 border-l-2">
  <div class="py-10 ">
    <UserPreviewInline user={comment.owner} />
    <div class="prose prose-sm mt-4 max-w-none text-gray-500">
      {@html html}
    </div>
    {#if comment?.answers}
      <div class="ml-5">
        {#each comment.answers as reply}
          <svelte:self comment={reply} />
        {/each}
      </div>
    {/if}
  </div>
</div>
