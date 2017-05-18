var gameResultFields = document.getElementsByClassName('game_result');
for (var i = 0; i < gameResultFields.length; ++i) {
    gameResultFields[i].onclick = function () {
        alert('111');
    };
}