(function() {

var user = $('.user');
if (user) {
  $.get('/' + $('#user-id').val() + '/getStatistic', function(data) {
    var statistic = JSON.parse(data);

    if (statistic.length) {
      google.charts.load('current', {'packages': ['corechart']});
      google.charts.setOnLoadCallback(drawChart.bind(this, statistic));
    }

  }).fail(function(data) {
    $('#error').html(data);
  });
}

function drawChart(statistic) {
  var monthNames = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь",
    "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];

  var data = new google.visualization.DataTable();
  data.addColumn('string', 'Месяц');
  data.addColumn('number', 'худший');
  data.addColumn('number', 'средний');
  data.addColumn('number', 'лучший');

  for (var i = 0; i < statistic.length; ++i) {
    var date = new Date(statistic[i].date);
    date = monthNames[date.getMonth()] + ', ' + date.getFullYear();
    data.addRow([date, statistic[i].min, statistic[i].avg, statistic[i].max]);
  }

  var options = {
    hAxis: {title: 'Месяц', titleTextStyle: {color: '#333'}},
    vAxis: {minValue: 0},
  };

  var chart = new google.visualization.AreaChart($('#statistics')[0]);
  chart.draw(data, options);
}

})();