$(document).ready(function() {
  var playerId;
  $('[data-toggle=modal]').click(function () {
    $('#player').val($(this).data('player'));
    playerId = $(this).data('id');
  });

  $('#toggle-admin').click(function() {
    $.get('/account/' + playerId + '/toggleAdmin', function(data) {
      console.log(data);
      if (data) {
          $('[data-id=' + playerId + ']').html("<span class='label label-success'><span class='glyphicon glyphicon-ok'></span></span>");
      }
      else {
          $('[data-id=' + playerId + ']').html("<span class='label label-danger'><span class='glyphicon glyphicon-remove'></span></span>");
      }
      location.reload();
    }).fail(function(data) {
      console.log(data);
    });
  });
});
