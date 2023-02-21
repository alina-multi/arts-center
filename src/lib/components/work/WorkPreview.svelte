<script lang="ts">
    import RatingPreview from "$lib/components/rating/RatingPreview.svelte";
    import UserPreviewInline from "$lib/components/user/UserPreviewInline.svelte";
    import type {Work} from "../../interfaces/Work";

    export let work: Work;
    let title: string;
    $: title = work.titles[0].title // For now, later use language

</script>
<li class="flex flex-col gap-2 rounded-md {work.subscribed ? ' ' : ''} ">
    <div class="group/item relative">
        <a href="/work/{work.id}" class="grid gap-2">
            {#if work.image}
                <img class="rounded-md" src={work.image.src} srcset={work.image.srcset}  alt="User"/>
            {/if}
            <div class=" inline-flex items-start justify-between font-medium text-gray-900 dark:text-zinc-100">
                <h3 class=" text-lg lg:text-sm">{title}</h3>
                {#if work.price}  <p class="ml-2 bg-green-600 px-2 py-1 rounded-md text-white">${work.price}</p>{/if}
            </div>
        </a>
        <div class="group/edit invisible group-hover/item:visible absolute top-3 right-3 text-white bg-black/50 pt-1 px-1 rounded-md transition-all">
            <RatingPreview rating={work.rating} comments={work.comments}/>
        </div>
    </div>

    <div class="flex justify-between items-center text-base font-medium lg:text-sm mt-auto">
        {#each work.owners as user}
            <UserPreviewInline {user}/>
        {/each}

        {#if work.subscribed}
            <span class="mr-2 shadow-md text-lg lg:text-base font-medium border border-amber-500 rounded-md px-2 dark:text-zinc-100">Pro</span>
        {/if}
    </div>
</li>
