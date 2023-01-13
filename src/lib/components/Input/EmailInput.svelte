<script lang="ts">
    import newUniqueId from 'locally-unique-id-generator'

    export let label, description, placeholder, value, error;


    // Generate a unique ID for the fields
    const id = newUniqueId();
    const descriptionId = id + "-description"
    const errorId = id + "-error"

    let primaryClass = "border-zinc-300 focus:border-indigo-300 focus:ring-indigo-200";
    let errorClass = "border-red-300 focus:border-red-300 focus:ring-red-200";
    let ariaDescribedBy
    $: ariaDescribedBy = (error) ? errorId : descriptionId;

</script>


<div class="flex items-center justify-center bg-white p-8">
    <div class="mx-auto w-full max-w-xs">
        <div>
            <label for={id} class="block text-sm font-medium text-zinc-900">
                {#if label}{label}{/if}
            </label>
            <input
                    {value}
                    id={id}
                    placeholder={placeholder}
                    aria-invalid={error}
                    aria-describedby={ariaDescribedBy}
                    class='block w-full rounded-md border sm:text-sm {error ? errorClass : primaryClass}'/>

            {#if error}
                <p id={errorId} class="mt-2 text-sm text-gray-500">{error}</p>
            {/if}

            {#if description}
                <p id={descriptionId} class="mt-2 text-sm text-gray-500">{description}</p>
            {/if}
        </div>
    </div>
</div>


