$('#avatar').change(function () {
    $('.avatar-file + label').html("<span class='glyphicon glyphicon-file'></span> " + this.files[0].name);
});

// $('#avatar').change(function () {
//     var popupAvatar = document.createElement('div');
//     popupAvatar.id = 'popup-avatar';
//
//     var popupContent = document.createElement('div');
//     popupContent.id = 'popup-content';
//
//     var closeButton = document.createElement('span');
//     closeButton.id = 'close-crop';
//     closeButton.className = "glyphicon glyphicon-remove";
//     $(closeButton).click(function () {
//         $('#popup-avatar').remove();
//     });
//
//     var uploadedImage = document.createElement('img');
//     uploadedImage.id = 'uploaded-image';
//
//     var submitCropBtn = document.createElement('button');
//     submitCropBtn.id = 'submit-crop';
//     submitCropBtn.innerHTML = 'применить';
//     submitCropBtn.click(function () {
//
//     });
//
//     $(popupContent).append(closeButton);
//     $(popupContent).append(uploadedImage);
//     $(popupContent).append(submitCropBtn);
//     $(popupAvatar).append(popupContent);
//     // uploadedImage.src = $('#avatar').val();
//     // alert($('#avatar').val());
//     var file_data = $('#avatar').prop('files')[0];
//     var form_data = new FormData();
//     form_data.append('tempImg', file_data);
//     $.ajax({
//         type: 'POST',
//         url: '/saveTempImage',
//         dataType: 'text',  // what to expect back from the PHP script, if anything
//         cache: false,
//         contentType: false,
//         processData: false,
//         data: form_data,
//         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//             success: function (data) {
//                 $('body').append(popupAvatar);
//                 $('#uploaded-image').attr('src', 'http://tmaster/' + data);
//                 $('#uploaded-image').Jcrop({
//                     // onSelect:    showCoords,
//                     bgColor:     'black',
//                     bgOpacity:   .4,
//                     setSelect:   [ 100, 100, 350, 350 ],
//                     aspectRatio: 1
//                 });
//
//                 // location.replace('/');
//             }
//         }).fail(function (data) {
//             // alert(data.responseText);
//         $('#error').html(data.responseText);
//     });
//     // $(this).Jcrop();
//
// });
