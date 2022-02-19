<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>


<script>
    alertify.set('notifier','delay', 8);
    alertify.defaults.glossary.title = "{{ config('app.name')}}"
    alertify.defaults.glossary.cancel = "{{ __('Zrušit')}}"

    alertify.defaults.theme.ok = "btn-a btn-a-blue";
    alertify.defaults.theme.cancel = "btn-a btn-a-red";
</script>
