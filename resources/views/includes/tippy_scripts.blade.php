
@if(config('app.debug'))
<!-- Development -->
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

@else

<!-- Production -->
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
@endif

<script>
window.addEventListener('load', function () {
    tippy('[data-tooltip]', {
        allowHTML: true,
        content: (reference) => reference.getAttribute('data-tooltip'),
        onMount(instance) {
            instance.popperInstance.setOptions({
                placement: instance.reference.getAttribute('data-placement') ?? 'top'
            });
        },
    });
});
</script>

