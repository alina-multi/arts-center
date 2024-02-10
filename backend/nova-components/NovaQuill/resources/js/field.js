Nova.booting((Vue, router, store) => {
  Vue.component('index-nova-quill', require('./components/QuillToHtml.vue'))
  Vue.component('detail-nova-quill', require('./components/QuillToHtml.vue'))
  Vue.component('form-nova-quill', require('./components/FormField'))
})
