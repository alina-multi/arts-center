<script lang='ts'>
    import Conversation from "$lib/components/chat/Conversation.svelte";
    export let data;
    console.log(data.thread)
    </script>
        
    <Conversation messages={data.thread.messages} />
