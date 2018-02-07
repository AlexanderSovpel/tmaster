(function() {

$('#avatar').change(function () {
  $('.avatar-file + label').html(
    "<span class='glyphicon glyphicon-file'></span> " + this.files[0].name
  );
});

})();