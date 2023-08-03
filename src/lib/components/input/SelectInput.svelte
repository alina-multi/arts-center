<script lang="ts">
  import { MultiSelect } from "svelte-multiselect";

  export let options, maxSelect, required, name, value;
  let multiselectProps, hiddenValue;
  // Default from value prop to format that component understands
  let selected = options.map(tagToOption).filter((option) => value.includes(Number(option.value)));
  $: {
    multiselectProps = {
      outerDivClass: "rounded-md border sm:text-sm h-10",
      ulSelectedClass: "h-8",
      liSelectedClass: "bg-amber-500",
      options: options.map(tagToOption),
      maxSelect,
      required
    };
  }
  // Back to array of id's for the backend
  $: hiddenValue = selected.map(({value}) => value).join(',')

  function tagToOption({title, id}) {
    return {
      label: title,
      value: id?.toString()
    }
  }
</script>
<MultiSelect bind:selected {...multiselectProps} />
<input type="hidden" {name} value={hiddenValue}/>