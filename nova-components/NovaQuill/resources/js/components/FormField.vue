<template>
  <default-field :field="field" :errors="errors" :show-help-text="showHelpText">
    <template slot="field">
      <quill-editor ref="myQuillEditor"
                    @change="onChange"
                    class="quill-editor w-full mb-5"
                    :class="errorClasses"
                    :options="editorOption"
      />
    </template>
  </default-field>
</template>

<script>
import { quillEditor } from 'vue-quill-editor'
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
  components: { quillEditor },
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  data () {
    return {
      editorOption: {
        modules: {
          toolbar: [
            ['bold', 'italic', 'underline', 'strike', 'link'],
            ['image', 'video'],
            ['blockquote', 'code-block'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'color': [] }, { 'background': [] }],
            ['clean']
          ]
        },
        placeholder: this.field.name
      },
    }
  },

  methods: {
    onChange({ quill }) {
      this.value = quill.getContents()
    },
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue () {
      this.$refs.myQuillEditor.quill.setContents(this.field.value || {})
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill (formData) {
      formData.set(this.field.attribute, JSON.stringify(this.value))
    },
  },
}
</script>
