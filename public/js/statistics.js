monthNames = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь",
    "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
var xhr = new XMLHttpRequest();
var statistic;
xhr.open('GET', '/getStatistic', false);
xhr.send();

if (xhr.status != 200) {
    document.getElementById('error').innerHTML = xhr.responseText;
}
else {
    statistic = JSON.parse(xhr.responseText);

    if (statistic.length) {
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);
    }
}

function drawChart() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Месяц');
    data.addColumn('number', 'худший');
    data.addColumn('number', 'средний');
    data.addColumn('number', 'лучший');

    for (var i = 0; i < statistic.length; ++i) {
        var date = new Date(statistic[i].date);
        // console.log(date);
        date = monthNames[date.getMonth()] + ', ' + date.getFullYear();
        data.addRow([date, statistic[i].min, statistic[i].avg, statistic[i].max]);
    }

    var options = {
        hAxis: {title: 'Месяц', titleTextStyle: {color: '#333'}},
        vAxis: {minValue: 0},
        // backgroundColor: { fill:'transparent' }
    };

    var chart = new google.visualization.AreaChart(document.getElementById('statistics'));
    chart.draw(data, options);
}
