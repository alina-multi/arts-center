<script lang="ts">
  import type { PageData } from "./$types";
  import { Icon } from "@steeze-ui/svelte-icon";
  import { UserCircle } from "@steeze-ui/heroicons";

  export let data: PageData;
  const profile = data.profile.data;
</script>
{JSON.stringify(data)}
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
            <div class="col">
              <label for="about" class="block text-sm font-medium leading-6 text-gray-900">EN</label>
              <div class="mt-2">
                <textarea id="about" name="about" rows="3"
                          class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                  {profile?.bio?.en}
                </textarea>
              </div>
            </div>
            <div class="col">
              <label for="about" class="block text-sm font-medium leading-6 text-gray-900">UK</label>
              <div class="mt-2">
                <textarea id="about" name="about" rows="3"
                          class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                  {profile?.bio?.uk}
                </textarea>
              </div>
            </div>
          </div>
          <p class="mt-3 text-sm leading-6 text-gray-600">Write a few sentences about yourself.</p>
        </div>
        <div class="sm:col-span-3">
          <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Country</label>
          <div class="mt-2">
            <select id="country" name="country" autocomplete="country-name"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
              <option>United States</option>
              <option>Canada</option>
              <option>Mexico</option>
            </select>
          </div>
        </div>

      </div>
    </div>

    <div class="border-b border-gray-900/10 pb-12">
      <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>

      <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-4">
          <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
          <div class="mt-2">
            <input id="email" name="email" type="email" autocomplete="email"
                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>
      </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
      <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
      <button type="submit"
              class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
        Save
      </button>
    </div>
</form>