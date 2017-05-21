var xhr = new XMLHttpRequest();
var statistic;
xhr.open('GET', '/getStatistic', false);
xhr.send();

if (xhr.status != 200) {
    document.getElementById('error').innerHTML = xhr.responseText;
}
else {
    statistic = JSON.parse(xhr.responseText);
    // console.log(statistic);

    if (statistic.length) {
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);
    }
}

function drawChart() {
    var rawData = [
        ['Месяц', 'худший', 'средний', 'лучший']
    ];
    for (var i = 0; i < statistic.length; ++i) {
        rawData[i + 1] = [
            statistic[i].date, statistic[i].min, statistic[i].avg, statistic[i].max
        ];
    }

    var data = google.visualization.arrayToDataTable(rawData);

    var options = {
        title: 'Статистика',
        hAxis: {title: 'Месяц', titleTextStyle: {color: '#333'}},
        vAxis: {minValue: 0},
        // backgroundColor: { fill:'transparent' }
        // isStacked: true
    };

    var chart = new google.visualization.AreaChart(document.getElementById('statistics'));
    chart.draw(data, options);
}
