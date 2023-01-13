<script lang="ts">
    export let type;
    export let label;
    export let spanLabel;
    export let placeholder;
    export let inputType;

let value = '';
let ariaInvalid = "false";
let ariaDescribedby = "email-description";
let style;
let primary = "border-zinc-300 focus:border-indigo-300 focus:ring-indigo-200";
let error = "border-red-300 focus:border-red-300 focus:ring-red-200";
    



  $: if (inputType === "primary") {
    style = primary;
  } else if (inputType === "error") {
    style = error;
    ariaInvalid = "true";
    ariaDescribedby = "email-error";
    spanLabel = "Please enter a valid email address";
    
  } else {
    style = primary;
  }

</script>


    <div class="flex items-center justify-center bg-white p-8">
        <div class="mx-auto w-full max-w-xs">
            <div>
                <label for="email" class="block text-sm font-medium text-zinc-900">{label}</label>
                <div class="mt-1">
                  <input 
                  {value}
                  type={type} 
                  name="email" 
                  id="email"
                  placeholder={placeholder}
                  aria-invalid={ariaInvalid} 
                  aria-describedby={ariaDescribedby}
                  class='block w-full rounded-md sm:text-sm {style}'/>
                  
                </div>
                <p class="mt-2 text-sm text-gray-500" id="email-description">{spanLabel}</p>
              </div>
    </div>
    </div>


