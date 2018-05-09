(function() {

$(document).ready(function() {
  var playerId;
  $('[data-toggle=modal]').click(function () {
    $('#player').val($(this).data('player'));
    playerId = $(this).data('id');
  });

  $('#toggle-admin').click(function() {
    $.get('/account/' + playerId + '/toggleAdmin', function(data) {
      console.log(data);
      location.reload();
    }).fail(function(data) {
      console.log(data);
    });
  });
});

})();