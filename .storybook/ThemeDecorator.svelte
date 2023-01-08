
<slot/>

<script>
  export let context;
  $: {
    if (context.globals.theme === 'dark') {
      document.documentElement.classList.add('dark', 'bg-black');
      document.documentElement.classList.remove('bg-white');
    } else {
      document.documentElement.classList.remove('dark', 'bg-black');
      document.documentElement.classList.add('bg-white');
    }
  }
</script>