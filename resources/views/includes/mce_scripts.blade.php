<script src='https://cdn.tiny.cloud/1/j5vqgy5ndunssxyopg389ejkgxxvkp2cs953mjgrx38altt1/tinymce/5/tinymce.min.js'
    referrerpolicy="origin">
</script>
<script>
    tinymce.init({
        selector: '#editor',
        plugins: 'image anchor link',
        menubar: 'file edit insert format',
        content_css : 'css/app.css',
        language: 'cs',
        images_upload_handler: function(blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '/img/upload');
            var token = '{{ csrf_token() }}';
            xhr.setRequestHeader("X-CSRF-Token", token);
            xhr.onload = function() {
                var json;
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                success(json.location);
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        }
    });

</script>
