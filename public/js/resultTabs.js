(function() {

var resultTabs = document.querySelector('#result-tabs');
if (resultTabs) {
    resultTabs = resultTabs.children;
}
var results = document.querySelector('#results');
if (results) {
  var resultTabs = document.querySelectorAll('.result-tab');
    $(resultTabs).click(function(e) {
      e.preventDefault();
      toggleResultTabs(this);

      var tabIndex = Array.prototype.indexOf.call(resultTabs, this);
      var table = document.querySelectorAll('.result-table')[tabIndex];
      toggleResultTables(table);
    });
}

function toggleResultTables(table) {
  $('.result-table').hide();
  $(table).show();
}

function toggleResultTabs(tab) {
  $('.result-tab').removeClass('active');
  $(tab).addClass('active');
}

$('[data-toggle=modal]').click(function () {
  $('#game-id').val($(this).data('id'));
  $('#game-result').val($(this).data('result'));
  $('#game-bonus').val($(this).data('bonus'));
});

$('#save-result').click(function() {
  $.ajax({
      type: 'POST',
      url: '/changeGameById',
      data: {
        id: $('#game-id').val(),
        result: $('#game-result').val(),
        bonus: $('#game-bonus').val()
      },
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: function (data) {
        console.log(data);
      }
    }).fail(function(data) {
      console.log(data.responseText);
    });

});

})();