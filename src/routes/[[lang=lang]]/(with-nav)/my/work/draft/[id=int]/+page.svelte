<script lang="ts">
  import type { PageData, ActionData } from "./$types";
  import FormGroup from "$lib/components/input/FormGroup.svelte";
  import WorkAddProgressSteps from "$lib/components/work/add/WorkAddProgressSteps.svelte";
  import InputGroup from "$lib/components/input/InputGroup.svelte";
  import TextInput from "$lib/components/input/TextInput.svelte";
  import SelectInput from "$lib/components/input/SelectInput.svelte";
  import TextAreaInput from "$lib/components/input/TextAreaInput.svelte";
  import { Tab, TabGroup, TabList, TabPanels } from "@rgossiaux/svelte-headlessui";
  import StyledTabList from "$lib/components/layout/StyledTabList.svelte";
  import StyledTab from "$lib/components/layout/StyledTab.svelte";
  import StyledTabPanel from "$lib/components/layout/StyledTabPanel.svelte";

  export let data: PageData;
  export let form: ActionData;
</script>
<WorkAddProgressSteps currentStep="2" />
<form method="post">
  <FormGroup h1="Main info">
    <InputGroup label="Category" error={form?.errors?.categories}>
      <SelectInput required options={data.categories} maxSelect={3} />
    </InputGroup>

    <TabGroup>
      {#if data.titles.length > 1}
        <StyledTabList>
          {#each data.titles as title}
            <StyledTab>
              {title.language}
            </StyledTab>
          {/each}
        </StyledTabList>
        <!-- without this hack with empty element it doesn't draw panels -->
      {:else }
        <TabList class="h-0">
          <Tab></Tab>
        </TabList>
      {/if}
      <TabPanels>
        {#each data.titles as title}
          <StyledTabPanel>
            <div class="space-y-3">
              <InputGroup error={form?.errors?.title} label="Title">
                <TextInput name="title" />
              </InputGroup>
              <InputGroup error={form?.errors?.description} label="Description">
                <TextAreaInput name="description" />
              </InputGroup>
            </div>
          </StyledTabPanel>
        {/each}
      </TabPanels>
    </TabGroup>
  </FormGroup>
</form>