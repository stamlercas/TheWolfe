Dropzone.autoDiscover = false;
jQuery(document).ready(function() {
    $("div#dropzone").dropzone({
        url: uploadRoute,
        maxFileSize: 10,
        maxFiles: 1,
        clickable: true,
        acceptedFiles: 'image/*',
        paramName: 'file',
        dictDefaultMessage: 'Drop Image to Upload',
        dictMaxFilesExceeded: 'You can only upload 1 image at a time',
        thumbnailWidth: "300",
        thumbnailHeight: "300",
        headers: {
            'X-CSRF-Token': $('input[name="_token"]').val()
            //'body': $('input[name="body"]').val()
        },
        success: uploadSuccess,
        uploadprogress: uploadProgress
        /*
        //settings so dropzone won't upload file automatically
        autoProcessQueue: false,
        uploadMultiple: false,
        parallelUploads: 100,
        */
        /*
        // The setting up of the dropzone
        init: function() {
          var myDropzone = this;

          // First change the button to actually tell Dropzone to process the queue.
          this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
            myDropzone.processQueue();
          });
        }
        */
    });
});

function uploadSuccess(file, data)
{
    $('#image_url').val(data['filename']);
    //alert($('#image_url').val());
    
}

function uploadProgress(file, progress, bytesSent)
{
}

function displayWarningBox(id)
{
    $(id).show();
}