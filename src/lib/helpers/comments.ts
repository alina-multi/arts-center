import toast from 'svelte-french-toast';
export function сommentValidations(value: string) {
    value = value.trim();
     toast.dismiss();
    if (!value) {
        toast.error('Comment cannot be empty');
        return;
    }
    if (value.length <= 2) {
        toast.error('Comment cannot be longer than 3 characters');
        return;
    }
    return true;
} 