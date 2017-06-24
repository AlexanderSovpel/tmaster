var squad = document.getElementById('squad');
if (squad) {
    squad.onchange = getPlayersList;
    getPlayersList();
}

$('#apply-button').click(function (e) {
  e.preventDefault();
  var tournamentId = $('#tournament-id').val();
  var squad = {
      squad: $('#squad').val()
  };

  $.ajax({
      type: 'POST',
      url: '/' + tournamentId + '/sendApplication',
      data: squad,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: function (data) {
          $('.error').html(data);
          getPlayersList();
      }
  }).fail(function (data) {
      $('.error').html(data.responseText);
  });
});

$('.players-tournament-btn').click(function (e) {
    e.preventDefault();
    var tournamentId = $('#tournament-id').val();
    var squad = {
        squad: $(this).siblings("[name='squad']").val()
    };

    $.ajax({
        type: 'POST',
        url: '/' + tournamentId + '/sendApplication',
        data: squad,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
            $('.error').html(data);
            location.reload();
        }
    }).fail(function (data) {
        $('.error').html(data.responseText);
    });
});

$('.add-player-btn').click(function() {
  var tournamentId = document.querySelector('#tournament-id').value;
  var squadId = $(this).siblings("[name='squad_id']").val();
  var url = '/' + tournamentId + '/' + squadId + '/getPlayers';
  $.get(url, function(data) {
    $('.error').after(data);
  }).fail(function(data) {
    console.log(data.responseText);
  });
});

function closeApply() {
  $('#popup').remove();
}

function getPlayersList() {
    var selectedSquad = squad.options[squad.selectedIndex].value;

    $.get('/getSquadFilling/' + selectedSquad, function (data) {
      var response = JSON.parse(data);
      $('#fill').html(response.playersCount + '/' + response.maxPlayers);
      $('#players').empty();
      for (var i = 0; i < response.players.length; ++i) {
        $('#players').append('<li>' + response.players[i].surname + ' ' +
          response.players[i].name + '</li>');
      }
    }).fail(function(data) {
        $('.error').html(data);
    });
}

function sendApplication() {
  var tournamentId = $('#tournament-id').val();
  var params = {
      squad: $('#apply-squad').val(),
      player_id: $('#player-select').val()
  };

  $.ajax({
      type: 'POST',
      url: '/' + tournamentId + '/sendApplication',
      data: params,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: function (data) {
        closeApply();
          $('.error').html(data);
          location.reload();
      }
  }).fail(function (data) {
      $('.error').html(data.responseText);
  });
}
