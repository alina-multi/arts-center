<script>
  import Steps from "$lib/components/nav/Steps.svelte";
  import { localePath } from "$lib/translations";

  export let currentStep = 1;
  const steps = [
    { label: "Upload images", href: localePath("/my/work/add") },
    { label: "Fill details" },
    { label: "Preview" }
  ];
</script>

<Steps {steps} {currentStep} />