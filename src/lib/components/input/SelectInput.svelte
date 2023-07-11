<script lang="ts">
  import { MultiSelect } from "svelte-multiselect";
  export let options, maxSelect, required;
  options = options.map(tag => ({label: tag.title}));
  const classes = {
    outerDivClass: "rounded-md border sm:text-sm h-10",
    ulSelectedClass: "h-8",
    liSelectedClass: "bg-amber-500"
  }
</script>

<MultiSelect {required} {options} {maxSelect} {...classes}/>