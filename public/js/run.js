(function() {

var tournamentId = document.getElementsByName('tournament')[0].value;
var part = document.getElementsByName('part')[0].value;
var stage = document.getElementsByName('stage')[0].value;
var squadId = document.getElementsByName('currentSquad')[0].value;
var players = $('.player');
var stages = ['conf', 'draw', 'game', 'rest'];
var wizardSteps = $('.bs-wizard-step');

if (stage == stages[2]) {
    for (var i = 0; i < players.length; ++i) {
        var playerId = players[i].querySelector('.player-id').value;
    }
}

for (var i = 0; i < wizardSteps.length; ++i) {
    if (i == stages.indexOf(stage)) {
        $(wizardSteps[i]).addClass('active');
        $(wizardSteps[i]).removeClass('complete');
        $(wizardSteps[i]).removeClass('disabled');
    }
    if (i < stages.indexOf(stage)) {
        $(wizardSteps[i]).addClass('complete');
        $(wizardSteps[i]).removeClass('active');
        $(wizardSteps[i]).removeClass('disabled');
    }
}

$('.player-result, .opponent-result').change(function() {
  var max = parseInt($(this).attr('max'));
  var min = parseInt($(this).attr('min'));
  var result = parseInt($(this).val());

  var player = $(this).parent()[0];
  var playerId = player.querySelector('.player-id, .opponent-id').value;
  var playerOldResult = player.querySelector('.player-result, .opponent-result').old_value;
  var playerBonus = player.querySelector('.player-bonus, .opponent-bonus').innerHTML.trim();

  if (!Number.isNaN(result)) {
      if ($(this).val() > max) {
          $(this).val(max);
      }
      else if ($(this).val() < min) {
          $(this).val(min);
      }

      $(this).addClass('played');
      toggleFinishBtn($('#current-game').val());
  }
  else {
      // нужно ли выполнять какие-то действия?
      $(this).val(min);
  }

  if (part == 'rr') {
      countBonus(player);
  }

  setResult(playerId, tournamentId, part, squadId, $(this).val(), playerOldResult, playerBonus, players[i]);
});

var games = $('.game');
var gamesCount = games.length;
var gamePaginationLinks = $('#game-pagination').children();
var finishGameBtns = $('.finish-game');
finishGameBtns.prop('disabled', true);

showGame(0);
$(gamePaginationLinks).addClass('disabled');
$(gamePaginationLinks[0]).removeClass('disabled');

function toggleFinishBtn(gameIndex) {
  var resultFelds = $(games[gameIndex]).find('.player-result, .opponent-result');
  var played = $(games[gameIndex]).find('.played');
  if (resultFelds.length != played.length) {
    $(finishGameBtns[gameIndex]).prop('disabled', true);
  }
  else {
    $(finishGameBtns[gameIndex]).prop('disabled', false);
  }
}

$(finishGameBtns).click(function() {
    var currentGame = $('#current-game').val();
    $('#current-game').val(++currentGame);
    $(this).hide();
    showGame(currentGame);
    $(gamePaginationLinks[currentGame]).removeClass('disabled');
});

var paginationLinks = $('#game-pagination > li > a');
for (var i = 0; i < paginationLinks.length; ++i) {
  paginationLinks[i].index = i;
  $(paginationLinks[i]).click(function(e) {
    e.preventDefault();
    if (!$(this).parent().hasClass('disabled')) {
      showGame(this.index);
    }
  });
}

// other functions
function setResult(playerId, tournamentId, part, squadId, playerResult, playerOldResult, bonus, player) {
    if (playerOldResult != undefined) {
        if (playerOldResult != playerResult) {
            var request = '/setGameResult?';
            var data = 'player_id=' + playerId + '&' +
                'tournament_id=' + tournamentId + '&' +
                'part=' + part + '&' +
                'squad_id=' + squadId + '&' +
                'result=' + playerResult + '&' +
                'bonus=' + bonus;

            if (playerOldResult != "") {
                request = '/changeGameResult?';
                data = 'player_id=' + playerId + '&' +
                    'tournament_id=' + tournamentId + '&' +
                    'part=' + part + '&' +
                    'squad_id=' + squadId + '&' +
                    'oldResult=' + playerOldResult + '&' +
                    'newResult=' + playerResult + '&' +
                    'bonus=' + bonus;
            }

            $.get(request + data, function(data) {
                console.log(data);
            }).fail(function(data) {
                console.log(data.responseText);
            });
        }
    }
}

function countBonus(player) {
    var opponent;
    if ($(player).siblings('.opponent')) {
        opponent = $(player).siblings('.opponent')[0];
    }

    var playerId = player.querySelector('.opponent-id').value;
    var playerResult = player.querySelector('.opponent-result').value;
    var playerBonus = player.querySelector('.opponent-bonus');
    var playerOldBonus = playerBonus.innerHTML;

    var opponentId = opponent.querySelector('.opponent-id').value;
    var opponentResult = opponent.querySelector('.opponent-result').value;
    var opponentBonus = opponent.querySelector('.opponent-bonus');
    var opponentOldBonus = opponentBonus.innerHTML;

    if (opponentResult) {
        if (playerResult > opponentResult) {
            playerBonus.innerHTML = 20;
            opponentBonus.innerHTML = 0;
        }
        else if (playerResult == opponentResult) {
            playerBonus.innerHTML = 10;
            opponentBonus.innerHTML = 10;
        }
        else {
            playerBonus.innerHTML = 0;
            opponentBonus.innerHTML = 20;
        }

        updateBonus(playerId, tournamentId, part, squadId, playerResult, playerOldBonus, playerBonus.innerHTML);
        updateBonus(opponentId, tournamentId, part, squadId, opponentResult, opponentOldBonus, opponentBonus.innerHTML);
    }
}

function updateBonus(playerId, tournamentId, part, squadId, playerResult, oldBonus, newBonus) {
    if (oldBonus != undefined) {
        oldBonus = (oldBonus == '') ? 0 : oldBonus;
        if (oldBonus != newBonus) {
            var request = '/updateBonus?';
            var data = 'player_id=' + playerId + '&' +
                'tournament_id=' + tournamentId + '&' +
                'part=' + part + '&' +
                'squad_id=' + squadId + '&' +
                'result=' + playerResult + '&' +
                'oldBonus=' + oldBonus + '&' +
                'newBonus=' + newBonus;

            $.get(request + data, function(data) {
              console.log(data);
            }).fail(function() {
                console.log(data);
            });
        }
    }
}

function showGame(gameIndex) {
  $(games).hide();
  $(games[gameIndex]).show();

  $(gamePaginationLinks).removeClass('active');
  $(gamePaginationLinks[gameIndex]).addClass('active');

  toggleFinishBtn(gameIndex);
}

$('#random-draw').click(function(e) {
  e.preventDefault();

  var drawPlayers = $('.draw-player');
  var lanes = [];
  var lanesCount = Math.floor(drawPlayers.length / 2);

  for (var i = 1; i <= lanesCount; ++i) {
    lanes.push(i + '-' + 1);
    lanes.push(i + '-' + 2);
  }
  lanes.sort(function(a, b) {
    return Math.random() - 0.5;
  });

  for (var i = 0; i < drawPlayers.length; ++i) {
    drawPlayers[i].querySelector('.lane-val').value = lanes[i].split('-')[0];
    drawPlayers[i].querySelector('.position').value = lanes[i].split('-')[1];
  }
});

})();