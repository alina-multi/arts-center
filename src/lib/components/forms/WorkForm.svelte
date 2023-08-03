<script>
  import StyledTabPanel from "$lib/components/layout/StyledTabPanel.svelte";
  import StyledTabList from "$lib/components/layout/StyledTabList.svelte";
  import { Tab, TabGroup, TabList, TabPanels } from "@rgossiaux/svelte-headlessui";
  import TextAreaInput from "$lib/components/input/TextAreaInput.svelte";
  import InputGroup from "$lib/components/input/InputGroup.svelte";
  import SelectInput from "$lib/components/input/SelectInput.svelte";
  import FormGroup from "$lib/components/input/FormGroup.svelte";
  import TextInput from "$lib/components/input/TextInput.svelte";
  import StyledTab from "$lib/components/layout/StyledTab.svelte";
  import SaveButton from "$lib/components/input/SaveButton.svelte";

  export let errors;
  export let data;
</script>
<FormGroup h1="Main info">
  <InputGroup label="Category" error={errors?.category}>
    <SelectInput required options={data.categories} value={data.category} name="category" maxSelect={3} />
  </InputGroup>

  <TabGroup>
    {#if data?.titles?.length > 1}
      <StyledTabList>
        {#each data.titles as title}
          <StyledTab>
            {title.language}
          </StyledTab>
        {/each}
      </StyledTabList>
      <!-- without this hack with empty element it doesn't draw panels -->
    {:else}
      <TabList class="h-0">
        <Tab />
      </TabList>
    {/if}
    <TabPanels>
      {#each data.titles as title}
        <StyledTabPanel>
          <div class="space-y-3">
            <InputGroup error={errors?.title} label="Title">
              <TextInput name="title" value={title.title} />
            </InputGroup>
            <InputGroup error={errors?.description} label="Description">
              <TextAreaInput name="description" value={title.description} />
            </InputGroup>
          </div>
        </StyledTabPanel>
      {/each}
    </TabPanels>
  </TabGroup>
  <SaveButton />
</FormGroup>