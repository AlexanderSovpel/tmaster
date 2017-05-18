/**
 * Created by Alexander on 14.05.17.
 */
var squad = document.getElementById('squad');
if (squad) {
    squad.onchange = getPlayersList;

    getPlayersList();
}

//TODO: адаптировать под финал
//TODO: в финале участь сравнение результатов в паре
var gameResultFields = document.getElementsByClassName('game_result');
for (var i = 0; i < gameResultFields.length; ++i) {
    var gameName = gameResultFields[i].name.split('_'); //WTF??? не разбивает на массив
    var blockSum = fillBlockSum(gameName);

    var gamesCount = 0;
    var games = document.getElementsByName(this.name);
    for (var j = 0; j < games.length; ++j) {
        if (games[j].value != '') {
            ++gamesCount;
        }
    }
    fillBlockAvg(blockSum, gamesCount, gameName);
    // fillBlockAvg(fillBlockSum(name));

    gameResultFields[i].onblur = function () {
        var name = this.name.split('_');

        if (this.old_value != this.value) {
            var request = '/setGameResult';
            var data = '?' +
                'player_id=' + name[1] + '&' +
                'tournament_id=' + name[2] + '&' +
                'stage=' + name[3] + '&' +
                'squad_id=' + name[4] + '&' +
                'result=' + this.value;

            if (this.old_value != "") {
                request = '/changeGameResult';
                var data = '?' +
                    'player_id=' + name[1] + '&' +
                    'tournament_id=' + name[2] + '&' +
                    'stage=' + name[3] + '&' +
                    'squad_id=' + name[4] + '&' +
                    'oldResult=' + this.old_value + '&' +
                    'newResult=' + this.value;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', request + data, false);
            xhr.send();

            if (xhr.status != 200) {
                // обработать ошибку
                // document.getElementById('error').innerHTML = xhr.responseText;
            } else {
                var blockSum = fillBlockSum(name);

                var gamesCount = 0;
                var games = document.getElementsByName(this.name);
                for (var j = 0; j < games.length; ++j) {
                    if (games[j].value != '') {
                        ++gamesCount;
                    }
                }
                fillBlockAvg(blockSum, gamesCount, name);
            }
        }
    };
}

function fillBlockSum(name) {
    var getResult = new XMLHttpRequest();
    var params = '?' +
        'player_id=' + name[1] + '&' +
        'tournament_id=' + name[2] + '&' +
        'stage=' + name[3] + '&' +
        'squad_id=' + document.getElementsByName('currentSquad')[0].value + '&' +
        'handicap=' + document.getElementById('handicap_' + name[1]).innerHTML;
    getResult.open('GET', '/sumBlock' + params, false);
    getResult.send();

    if (getResult.status != 200) {
        document.getElementById('error').innerHTML = getResult.responseText;
    }
    else {
        var blockSum = getResult.responseText;
        var sum = document.getElementById('sum_result_' + name[1]);
        sum.innerHTML = blockSum;
        return blockSum;
    }
}

function fillBlockAvg(blockSum, gamesCount, name) {
    var blockAvg = blockSum / gamesCount;

    if (isNaN(blockAvg))
        blockAvg = 0;

    var avg = document.getElementById('avg_result_' + name[1]);
    avg.innerHTML = blockAvg.toFixed(2);
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