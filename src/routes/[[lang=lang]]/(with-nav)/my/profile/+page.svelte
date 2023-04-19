<script lang="ts">
  import type { PageData } from "./$types";
  import { Icon } from "@steeze-ui/svelte-icon";
  import { UserCircle } from "@steeze-ui/heroicons";
  import EmailInput from "$lib/components/input/EmailInput.svelte";
  import PasswordInput from "$lib/components/input/PasswordInput.svelte";
  import TextInput from "$lib/components/input/TextInput.svelte";
  import TextAreaInput from "$lib/components/input/TextAreaInput.svelte";
  import { availableLocales } from "$lib/translations";

  export let data: PageData;
  const profile = data.profile.data;
</script>
<form method="post">
  <div class="space-y-12">
    <div class="border-b border-gray-900/10 pb-12">
      <h2 class="text-base font-semibold leading-7 text-gray-900">Profile</h2>
      <p class="mt-1 text-sm leading-6 text-gray-600">This information will be displayed publicly so be careful what you
        share.</p>

      <div class="col-span-full">
        <label for="avatar" class="block text-sm font-medium leading-6 text-gray-900">Photo</label>
        <div class="mt-2 flex items-center gap-x-3">
          {#if profile?.avatar?.src}
            <img src={profile.avatar.src} srcset={profile.avatar.srcset} class="h-12 w-12 rounded-full" />
          {:else}
            <Icon src={UserCircle} class="h-12 w-12 text-gray-300" aria-hidden="true" />
          {/if}
          <input
            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
            type="file" name="avatar" id="avatar" accept="image/png, image/jpeg" />
        </div>
      </div>

      <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-4">
          <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
          <div class="mt-2">
            <div
              class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
              <span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">arts.center/</span>
              <input type="text" name="username" id="username" value={profile.username}
                     class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                     placeholder="janesmith" />
            </div>
          </div>
        </div>

        <div class="col-span-full">
          <h3>Biography</h3>
          <div class="grid grid-cols-2 gap-3">
            {#each availableLocales as locale}
              <div class="col">
                <TextAreaInput name="biography[{locale}]" label={locale} value={profile?.bios?.[locale] ?? ''} />
              </div>
            {/each}
          </div>
          <p class="mt-3 text-sm leading-6 text-gray-600">Write a few sentences about yourself.</p>
        </div>
        <div class="sm:col-span-3">
          <TextInput name="country" label="Country" value={profile.country} />
        </div>
      </div>
    </div>
    <div class="mt-6 flex items-center justify-end gap-x-6">
      <button type="submit"
              class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
        Save
      </button>
    </div>
</form>

<form method="post">
  <div class="border-b border-gray-900/10 pb-12">
    <h2 class="text-base font-semibold leading-7 text-gray-900">Login Information</h2>
    {#if !profile?.email_verified_at}
      <p class="mt-1 text-sm leading-6 text-gray-600">Email awaiting confirmation</p>
    {/if}
    <EmailInput name="email" label="email" value={profile.email} />
    <PasswordInput label="password" name="password" autocomplete="off" />
    <PasswordInput label="confirm password" name="password_confirmation" autocomplete="off" />
  </div>
  <div class="mt-6 flex items-center justify-end gap-x-6">
    <button type="submit"
            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
      Save
    </button>
  </div>
</form>
