<script lang="ts">
  import type { PageData, ActionData } from "./$types";
  import FormGroup from "$lib/components/input/FormGroup.svelte";
  import WorkAddProgressSteps from "$lib/components/work/add/WorkAddProgressSteps.svelte";
  import InputGroup from "$lib/components/input/InputGroup.svelte";
  import FileInput from "$lib/components/input/FileInput.svelte";
  import TextInput from "$lib/components/input/TextInput.svelte";
  import TagInput from "$lib/components/input/TagInput.svelte";
  import MultiSelect from 'svelte-multiselect'
  import SelectInput from "$lib/components/input/SelectInput.svelte";
  export let data: PageData;
</script>
<WorkAddProgressSteps currentStep="2"/>
<form method="post">
  <FormGroup h1="Main info">
    <InputGroup label="Title">
      <TextInput name="title" />
    </InputGroup>
    <InputGroup label="Category">
<!--      <TagInput name="category" {options}/>-->
      <SelectInput options={data.categories} maxSelect={3}/>
    </InputGroup>
  </FormGroup>
</form>