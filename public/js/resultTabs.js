var resultTabs = document.querySelector('#result-tabs');
if (resultTabs) {
    resultTabs = resultTabs.children;
}
var results = document.querySelector('#results');
if (results) {
    results = results.children;
    qResultsTab = document.getElementById('show-qualification-results');
    qResultsTab.onclick = function (e) {
        e.preventDefault();
        toggleResults('qualification');
        toggleTabActive(qResultsTab);
    };

    fResultsTab = document.getElementById('show-final-results');
    if (fResultsTab) {
      fResultsTab.onclick = function (e) {
          e.preventDefault();
          toggleResults('final');
          toggleTabActive(fResultsTab);
      };
    }

    allResultsTab = document.getElementById('show-all-results');
    allResultsTab.onclick = function (e) {
        e.preventDefault();
        toggleResults('all');
        toggleTabActive(allResultsTab);
    };
}

function toggleResults(resultName) {
    for (var i = 0; i < results.length; ++i) {
        results[i].hidden = (results[i].id != resultName + '-results');
        // $(results[i]).toggleClass('hidden');
    }
}
function toggleTabActive(tab) {
    for (var i = 0; i < resultTabs.length; ++i) {
        $(resultTabs[i]).removeClass('active');
    }
    $(tab).parent().addClass('active');
}

$('[data-toggle=modal]').click(function () {
  $('#game-id').val($(this).data('id'));
  $('#game-result').val($(this).data('result'));
});
