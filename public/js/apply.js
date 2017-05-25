/**
 * Created by Alexander on 14.05.17.
 */
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
          $('#error').html(data);
          getPlayersList();
      }
  }).fail(function (data) {
      $('#error').html(data.responseText);
  });
});

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
      $('#error').html(data);
    });
}

// var players = document.querySelectorAll('.player');
// for (var i = 0; i < players.length; ++i) {
//     var playerId = players[i].querySelector('.player-id').value;
//     var tournamentId = document.getElementsByName('tournament')[0].value;
//     var part = document.getElementsByName('part')[0].value;
//     var squadId = document.getElementsByName('currentSquad')[0].value;
//
//     var blockSum = fillBlockSum(playerId, tournamentId, part, squadId);
//     var gamesCount = players[i].querySelectorAll(".played").length;
//     fillBlockAvg(blockSum, gamesCount, playerId);
// }
