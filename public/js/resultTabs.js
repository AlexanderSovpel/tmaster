var resultTabs = document.querySelector('#result-tabs');
if (resultTabs) {
    resultTabs = resultTabs.children;
}
var results = document.querySelector('#results');
if (results) {
  var resultTabs = document.querySelectorAll('.result-tab');
  // for(var i = 0; i < resultTabs.length; ++i) {
    $(resultTabs).click(function(e) {
      e.preventDefault();
      toggleResultTabs(this);

      var tabIndex = resultTabs.indexOf(this);
      var table = document.querySelectorAll('.result-table')[tabIndex];
      toggleResultTables(table);
    });
  // }

    // results = results.children;
    // qResultsTab = document.getElementById('show-qualification-results');
    // qResultsTab.onclick = function (e) {
    //     e.preventDefault();
    //     toggleResults('qualification');
    //     toggleTabActive(qResultsTab);
    // };
    //
    // fResultsTab = document.getElementById('show-final-results');
    // if (fResultsTab) {
    //   fResultsTab.onclick = function (e) {
    //       e.preventDefault();
    //       toggleResults('final');
    //       toggleTabActive(fResultsTab);
    //   };
    // }
    //
    // allResultsTab = document.getElementById('show-all-results');
    // allResultsTab.onclick = function (e) {
    //     e.preventDefault();
    //     toggleResults('all');
    //     toggleTabActive(allResultsTab);
    // };
}

// function toggleResults(resultName) {
//     for (var i = 0; i < results.length; ++i) {
//         results[i].hidden = (results[i].id != resultName + '-results');
//         // $(results[i]).toggleClass('hidden');
//     }
// }

function toggleResultTables(table) {
  $('.result-table').hide();
  $(table).show();
}

function toggleResultTabs(tab) {
  $('.result-tab').removeClass('active');
  $(tab).addClass('active');
}

// function toggleTabActive(tab) {
//     for (var i = 0; i < resultTabs.length; ++i) {
//         $(resultTabs[i]).removeClass('active');
//     }
//     $(tab).parent().addClass('active');
// }

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
