<script>
  import FormGroup from "$lib/components/input/FormGroup.svelte";
  import FileInput from "$lib/components/input/FileInput.svelte";
  import InputGroup from "$lib/components/input/InputGroup.svelte";
  import SaveButton from "$lib/components/input/SaveButton.svelte";
  import WorkAddProgressSteps from "$lib/components/work/add/WorkAddProgressSteps.svelte";
  const accept = "image/png, image/jpeg, image/webp";
</script>
<WorkAddProgressSteps/>
<form enctype="multipart/form-data" class="mt-4">
  <FormGroup h1="What have you been working on?" h2="Minimum 1600px width recommended. Max 10MB each. Only upload media you own the rights to.">
    <InputGroup label="Main image">
      <FileInput required name="main" {accept} />
    </InputGroup>
    <InputGroup label="Additional images">
      <FileInput name="more" multiple {accept} />
    </InputGroup>
    <SaveButton />
  </FormGroup>
</form>