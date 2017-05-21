/**
 * Created by Alexander on 14.05.17.
 */
var squad = document.getElementById('squad');
if (squad) {
    squad.onchange = getPlayersList;

    getPlayersList();
}

var applyButton = document.getElementById('apply-button');
applyButton.onclick = function (e) {
    e.preventDefault();
    var tournamentId = document.getElementById('tournament-id').value;
    var squad = {
        squad: document.getElementById('squad').value
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
};

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

var postResultButtons = document.querySelectorAll('.post-result');
for (var i = 0; i < postResultButtons.length; ++i) {
    postResultButtons[i].onclick = function () {
        var player = this.closest('.player');
        var resultDiv = this.closest('.result');
        var playerId = player.querySelector('.player-id').value;
        var playerResult = resultDiv.querySelector('.player-result').value;
        var playerOldResult = resultDiv.querySelector('.player-result').old_value;
        var playerBonus = player.querySelector('.player-bonus').innerHTML.trim();
        var tournamentId = document.getElementsByName('tournament')[0].value;
        var part = document.getElementsByName('part')[0].value;
        var squadId = document.getElementsByName('currentSquad')[0].value;
        setResult(playerId, tournamentId, part, squadId, playerResult, playerOldResult, playerBonus);

        resultDiv.querySelector('.player-result').className += ' played';

        var blockSum = fillBlockSum(playerId, tournamentId, part, squadId);
        var gamesCount = player.querySelectorAll(".played").length;
        fillBlockAvg(blockSum, gamesCount, playerId);
    }
}

var postOpponentResultButtons = document.querySelectorAll('.post-opponent-result');
for (var i = 0; i < postOpponentResultButtons.length; ++i) {
    postOpponentResultButtons[i].onclick = function () {
        var player = this.closest('.opponent');
        var playerId = player.querySelector('.opponent-id').value;
        var playerResult = player.querySelector('.opponent-result').value;
        var playerOldResult = player.querySelector('.opponent-result').old_value;
        var playerBonus = player.querySelector('.opponent-bonus').innerHTML;
        playerBonus = (playerBonus) ? playerBonus : 0;
        var tournamentId = document.getElementsByName('tournament')[0].value;
        var part = document.getElementsByName('part')[0].value;
        var squadId = document.getElementsByName('currentSquad')[0].value;
        setResult(playerId, tournamentId, part, squadId, playerResult, playerOldResult, playerBonus);
        countBonus(player);
    }
}

function fillBlockSum(playerId, tournamentId, part, squad) {
    var getResult = new XMLHttpRequest();
    var params = '?' +
        'player_id=' + playerId + '&' +
        'tournament_id=' + tournamentId + '&' +
        'part=' + part + '&' +
        'squad_id=' + squad;

    getResult.open('GET', '/sumBlock' + params, false);
    getResult.send();

    if (getResult.status != 200) {
        document.getElementById('error').innerHTML = getResult.responseText;
    }
    else {
        var blockSum = getResult.responseText;
        var sum = document.getElementById('sum_result_' + playerId);
        sum.innerHTML = blockSum;
        return blockSum;
    }
}

function fillBlockAvg(blockSum, gamesCount, playerId) {
    var blockAvg = blockSum / gamesCount;

    if (isNaN(blockAvg))
        blockAvg = 0;

    var avg = document.getElementById('avg_result_' + playerId);
    avg.innerHTML = blockAvg.toFixed(2);
}

function setResult(playerId, tournamentId, part, squadId, playerResult, playerOldResult, bonus) {
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

            var xhr = new XMLHttpRequest();
            xhr.open('GET', request + data, false);
            xhr.send();

            if (xhr.status != 200) {
                document.getElementById('error').innerHTML = xhr.responseText;
            } else {
                console.log(xhr.responseText);
            }
        }
    }
}

function countBonus(player) {
    var opponent;
    if (player.nextElementSibling) {
        opponent = player.nextElementSibling;
    }
    else {
        opponent = player.previousElementSibling;
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

            var xhr = new XMLHttpRequest();
            xhr.open('GET', request + data, false);
            xhr.send();

            if (xhr.status != 200) {
                document.getElementById('error').innerHTML = xhr.responseText;
            } else {
                console.log(xhr.responseText);
            }
        }
    }
}

function getPlayersList() {
    var selectedSquad = squad.options[squad.selectedIndex].value;

    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/getSquadFilling/' + selectedSquad, false);
    xhr.send();

    if (xhr.status != 200) {
        document.getElementById('error').innerHTML = xhr.responseText;
    } else {
        var response = JSON.parse(xhr.responseText);
        var maxPlayers = document.getElementById('fill');
        maxPlayers.innerHTML = response.playersCount + '/' + response.maxPlayers; // responseText -- текст ответа.

        var players = document.getElementById('players');
        while (players.firstChild) {
            players.removeChild(players.firstChild);
        }

        for (var i = 0; i < response.players.length; ++i) {
            var player = document.createElement('li');
            player.innerHTML = response.players[i].surname + ' ' + response.players[i].name;
            players.appendChild(player);
        }
    }
}