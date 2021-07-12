<script>
const notifications = {!! json_encode(session('notifications')) !!} || []
window.addEventListener('load', function() {
        notifications.forEach(element => {
            alertify.notify(element.message, element.type || 'message', element.duration || 0);
        })
    }
)
</script>
