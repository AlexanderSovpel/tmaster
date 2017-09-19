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
        var blockSum = fillBlockSum(playerId, tournamentId, part, squadId);
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

// $('.player-result').focus(function () {
//     var postButton = $(this).parent().find('.post-result');
//     $(postButton).show();
// }).blur(function () {
//     if (!this.value || this.value == this.old_value) {
//       var postButton = $(this).parent().find('.post-result');
//         $(postButton).hide();
//     }
// });

// $('.opponent-result').focus(function () {
//     var postButton = $(this).parent().find('.post-opponent-result');
//     $(postButton).show();
// }).blur(function () {
//     if (!this.value || this.value == this.old_value) {
//         var postButton = $(this).parent().find('.post-opponent-result');
//         $(postButton).hide();
//     }
// });

$('.player-result, .opponent-result').change(function() {
  var max = parseInt($(this).attr('max'));
  var min = parseInt($(this).attr('min'));
  var result = parseInt($(this).val());

  if (!Number.isNaN(result)) {
      if ($(this).val() > max) {
          $(this).val(max);
      }
      else if ($(this).val() < min) {
          $(this).val(min);
      }

      $(this).addClass('played');
      checkResults($('#current-game').val());
  }
  else {
      // нужно ли выполнять какие-то действия?
      $(this).val(min);
  }

  if (part == 'rr') {
      var player = $(this).parent();
      countBonus(player[0]);
  }
});

// $('.post-result').click(function() {
  // var player = this.closest('.player');
  // var playerId = player.querySelector('.player-id').value;
  // var playerResult = player.querySelector('.player-result').value;
  // var playerOldResult = player.querySelector('.player-result').old_value;
  // var playerBonus = player.querySelector('.player-bonus').innerHTML.trim();
  // var tournamentId = document.getElementsByName('tournament')[0].value;
  // var part = document.getElementsByName('part')[0].value;
  // var squadId = document.getElementsByName('currentSquad')[0].value;
  // setResult(playerId, tournamentId, part, squadId, playerResult, playerOldResult, playerBonus);
  //
  //   $(player.querySelector('.player-result')).addClass('played');
  //   $(this).hide();
  //
  //   var currentGame = $('#current-game').val();
  //   checkResults(currentGame);
// });

// $('.post-opponent-result').click(function() {
    // var player = this.closest('.opponent');
    // var playerId = player.querySelector('.opponent-id').value;
    // var playerResult = player.querySelector('.opponent-result').value;
    // var playerOldResult = player.querySelector('.opponent-result').old_value;
    // var playerBonus = player.querySelector('.opponent-bonus').innerHTML;
    // playerBonus = (playerBonus) ? playerBonus : 0;
    // var tournamentId = document.getElementsByName('tournament')[0].value;
    // var part = document.getElementsByName('part')[0].value;
    // var squadId = document.getElementsByName('currentSquad')[0].value;
    // setResult(playerId, tournamentId, part, squadId, playerResult, playerOldResult, playerBonus, player);
    //
    // $(player.querySelector('.opponent-result')).addClass('played');
    // $(this).hide();
    //
    // var currentGame = $('#current-game').val();
    // checkResults(currentGame);
// });

var games = $('.game');
var gamesCount = games.length;
var gamePaginationLinks = $('#game-pagination').children();
var finishGameBtns = $('.finish-game');
finishGameBtns.prop('disabled', true);

showGame(0);
$(gamePaginationLinks).addClass('disabled');
$(gamePaginationLinks[0]).removeClass('disabled');

// checkResults(0);

// $('.player-result, .opponent-result').change(function() {
//   var currentGame = $('#current-game').val();
//   checkResults(currentGame);
// });

function checkResults(gameIndex) {
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
    var tournamentId = document.getElementsByName('tournament')[0].value;
    var part = document.getElementsByName('part')[0].value;
    var squadId = document.getElementsByName('currentSquad')[0].value;

    var currentGame = $('#current-game').val();
    var players = $(games[currentGame]).find('.player, .opponent');
    for (var i = 0; i < players.length; ++i) {
        var playerId = players[i].querySelector('.player-id').value;
        var playerResult = players[i].querySelector('.player-result').value;
        var playerOldResult = players[i].querySelector('.player-result').old_value;
        var playerBonus = players[i].querySelector('.player-bonus').innerHTML.trim();
        // setResult(playerId, tournamentId, part, squadId, playerResult, playerOldResult, playerBonus, players[i]);
        // $(players[i].querySelector('.player-result')).addClass('played');

    }

    if (currentGame == gamesCount - 1) {
      // location.href = '/' + tournamentId + '/run/' + part + '/rest/' + squadId;

      $.ajax({
              type: 'POST',
              url: '/' + tournamentId + '/run/' + part + '/rest/' + squadId,
              data: null,
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              success: function (data) {
                document.body = data;
              },
              error: function (data) {
                document.body = data;
              }
            });
    }
    else {
      $('#current-game').val(++currentGame);
      $(this).hide();
      showGame(currentGame);
      $(gamePaginationLinks[currentGame]).removeClass('disabled');
    }
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
                // if (part == 'q') {
                  // fillBlockSum(playerId, tournamentId, part, squadId);
                // }
                // else {
                //   countBonus(player);
                // }
                console.log(data);
            }).fail(function(data) {
                console.log(data.responseText);
            });
        }
    }
}

function fillBlockSum(playerId, tournamentId, part, squad) {
  var blockSum = 0;
    var params = '?' +
        'player_id=' + playerId + '&' +
        'tournament_id=' + tournamentId + '&' +
        'part=' + part + '&' +
        'squad_id=' + squad;

    $.get('/sumBlock' + params, function (data) {
        blockSum = data;
        $('#sum_result_' + playerId).html(blockSum);
        var gamesCount = $('.player-id[value=' + playerId + ']').parent().find(".played").length;
        fillBlockAvg(blockSum, gamesCount, playerId);
        // return data;
    }).fail(function(data) {
        console.log(data);
    });

    return blockSum;
}

function fillBlockAvg(blockSum, gamesCount, playerId) {
    var blockAvg = blockSum / gamesCount;

    if (isNaN(blockAvg))
        blockAvg = 0;

    var avg = $('#avg_result_' + playerId).html(blockAvg.toFixed(2));
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

    var tournamentId = document.getElementsByName('tournament')[0].value;
    var part = document.getElementsByName('part')[0].value;
    var squadId = document.getElementsByName('currentSquad')[0].value;

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

  checkResults(gameIndex);
}
