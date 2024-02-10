<template>
  <div class="flex border-b border-40 -mx-6 px-6">
    <div class="w-1/4 py-4"><h4 class="font-normal text-80">{{this.field.name}}</h4></div>
    <div class="w-3/4 py-4 break-words" v-html="quillToHtml()"/>
  </div>
</template>

<script>
import { QuillDeltaToHtmlConverter } from 'quill-delta-to-html';
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
    methods: {
      quillToHtml() {
        return new QuillDeltaToHtmlConverter(this.field.value.ops, {}).convert()
      }
    }
}
</script>
