(function() {

var tournamentId = $('#tournament-id').val();

var squad = $('#squad');
if (squad) {
  squad.change(getPlayersList);
  getPlayersList();
}

$('#apply-button').click(function (e) {
  e.preventDefault();
  var body = {
    squad: $('#squad').val()
  };

  $.ajax({
    type: 'POST',
    url: '/' + tournamentId + '/sendApplication',
    data: body,
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    success: function (data) {
      $('.message').html(data);
      getPlayersList();
    }

  }).fail(function (data) {
    $('.message').html(data.responseText);
  });
});

$('.players-tournament-btn').click(function (e) {
  e.preventDefault();
  var body = {
    squad: $(this).siblings("[name='squad']").val()
  };

  $.ajax({
    type: 'POST',
    url: '/' + tournamentId + '/sendApplication',
    data: body,
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    success: function (data) {
      $('.message').html(data);
      location.reload();
    }

  }).fail(function (data) {
    $('.message').html(data.responseText);
  });
});

$('.add-player-btn').click(function() {
  var squadId = $(this).siblings("[name='squad_id']").val();
  $.get('/' + tournamentId + '/' + squadId + '/getPlayers', function(data) {
    $('.message').after(data);

  }).fail(function(data) {
    console.error(data.responseText);
  });
});

$('.no-application-player-btn').click(function() {
  var squadId = document.querySelector("[name='currentSquad']").value;
  $.get('/' + tournamentId + '/' + squadId + '/getPlayers', function(data) {
    $('.container').after(data);

  }).fail(function(data) {
    console.error(data.responseText);
  });
});

function closeApply() {
  $('#popup').remove();
}

function getPlayersList() {
  var selectedSquad = squad[0].options[squad[0].selectedIndex].value;

  $.get('/getSquadFilling/' + selectedSquad, function (data) {
    var response = JSON.parse(data);

    $('#fill').html(response.playersCount + '/' + response.maxPlayers);
    $('#players').empty();

    for (var i = 0; i < response.players.length; ++i) {
      $('#players').append('<li>' + response.players[i].surname + ' ' +
        response.players[i].name + '</li>');
    }

  }).fail(function(data) {
    $('.message').html(data);
  });
}

function sendApplication() {
  var body = {
    squad: $('#apply-squad').val(),
    player_id: $('#player-select').val()
  };

  $.ajax({
    type: 'POST',
    url: '/' + tournamentId + '/sendApplication',
    data: body,
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    success: function (data) {
      closeApply();
      $('.message').html(data);
      location.reload();
    }

  }).fail(function (data) {
    $('.message').html(data.responseText);
  });
}

})();