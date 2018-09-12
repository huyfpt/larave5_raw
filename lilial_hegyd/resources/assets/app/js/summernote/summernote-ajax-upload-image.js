function ajaxUploadImage(file, that, model){
    var data = new FormData();
    data.append('file', file);
    data.append('model', model);
    $.ajax({
        data: data,
        type: 'post',
        url: '/admin/summernote/upload/image',
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
            $(that).summernote('insertImage', location.origin+'/storage/'+model+'/'+data['name']);
        }
    });
}