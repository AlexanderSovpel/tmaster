var newTournamentForm = document.getElementById('new-tournament');
if (newTournamentForm) {
  sessionStorage.setItem('currentStep', 0);
  $('.form-control').change(function() {
    sessionStorage.setItem(this.name, this.value);
    console.log(sessionStorage.getItem(this.name));
  });
  var formFields = $('.form-control');
  for (var i = 0; i < formFields.length; ++i) {
    if (!formFields[i].value) {
      formFields[i].value = sessionStorage.getItem(formFields[i].name)
    }
  }

  var contactPerson = document.querySelector('#contact-person');
  $(contactPerson).change(function() {
    var adminId = this.options[this.selectedIndex].value;
    $.get('/getContact/' + adminId, function(data) {
      var adminUser = JSON.parse(data);
      $('#contact-phone').val(adminUser.phone);
      $('#contact-email').val(adminUser.email);
    }).fail(function(data) {
        console.log(data);
      });
  });

  $('#save').click(function(e) {
    e.preventDefault();
    $('#step').val(0);
    sessionStorage.setItem('currentStep', 0);
    $.ajax({
        type: 'POST',
        url: '/createTournament',
        data: {
          name: $('#name').val(),
          location: $('#location').val(),
          type: $('input[name=type]:checked').val(),
          oil_type: $('#oil-type').val(),
          description: $('#description').val(),

          handicap_type: $('#handicap-type').val(),
          handicap_value: $('#handicap-value').val(),
          handicap_max_game: $('#handicap-max-game').val(),

          qualification_games: $('#qualification-games').val(),
          qualification_entries: $('#qualification-entries').val(),
          qualification_finalists: $('#qualification-finalists').val(),

          rr_players: $('#rr-players').val(),
          rr_win_bonus: $('#rr-win-bonus').val(),
          rr_draw_bonus: $('#rr-draw-bonus').val(),

          squads_count: $('#squads-count').val(),
          squad_date: $('input[name="squad_date[]"]').map(function() {return this.value;}).get(),
          squad_start_time: $('input[name="squad_start_time[]"]').map(function() {return this.value;}).get(),
          squad_end_time: $('input[name="squad_end_time[]"]').map(function() {return this.value;}).get(),
          squad_max_players: $('input[name="squad_max_players[]"]').map(function() {return this.value;}).get(),

          qualification_fee: $('#qualification-fee').val(),
          allow_reentry: $('#allow-reentry').val(),
          reentries_amount: $('#reentries-amount').val(),
          reentry_fee: $('#reentry-fee').val(),

          rr_date: $('#rr-date').val(),
          rr_start_time: $('#rr-start-time').val(),
          rr_end_time: $('#rr-end-time').val(),

          contact_person: $('#contact-person').val(),
          contact_phone: $('#contact-phone').val(),
          contact_email: $('#contact-email').val(),
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
            location.replace('/');
        }
    }).fail(function (data) {
        console.log(data.responseText);
        $('#error').html(data.responseText);
    });
  });

    var currentStep = newTournamentForm.querySelector('#step');
    if (sessionStorage.getItem('currentStep'))
        currentStep.value = sessionStorage.getItem('currentStep');

    var steps = newTournamentForm.querySelectorAll('.creation-step');
    var nextStepBtn = newTournamentForm.querySelector('#next-step');
    var prevStepBtn = newTournamentForm.querySelector('#prev-step');
    var saveBtn = newTournamentForm.querySelector('#save');

    showStep(steps, currentStep.value);
    toggleStepBtnVisibility(newTournamentForm);
    var wizardSteps = document.querySelectorAll('.bs-wizard-step');
    for(var i = 0; i < wizardSteps.length; ++i) {
      $(wizardSteps[i]).click(function () {
        var w = Array.prototype.slice.call($('.bs-wizard-step'));
        var step = w.indexOf(this);
        if (!$(this).hasClass('disabled')) {
          currentStep.value = step;
          showStep(steps, step);
          toggleStepBtnVisibility(newTournamentForm);
        }
      });

      toggleWizardSteps(currentStep.value);
    }

    prevStepBtn.onclick = function () {
      var prevWizardStep = $('.bs-wizard-step')[currentStep.value];
      $(prevWizardStep).removeClass('active');
      $(prevWizardStep).addClass('disabled');

        --currentStep.value;

        var currWizardStep = $('.bs-wizard-step')[currentStep.value];
        $(currWizardStep).removeClass('complete');
        $(currWizardStep).addClass('active');

        sessionStorage.setItem('currentStep', currentStep.value);
        showStep(steps, currentStep.value);
        toggleStepBtnVisibility(newTournamentForm);
    };

    nextStepBtn.onclick = function () {
      var currentStepDiv = $('.creation-step')[currentStep.value];
      var currentStepFields = $(currentStepDiv).find('.form-control');
      for(var i = 0; i < currentStepFields.length; ++i) {
        if (!currentStepFields[i].value) {
          console.log('not all fields are filled!');
          $('#error').html('<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><span>Заполните все поля!</span></div>');
          return;
        }
      }

      var prevWizardStep = $('.bs-wizard-step')[currentStep.value];
      $(prevWizardStep).removeClass('active');
      $(prevWizardStep).addClass('complete');

        ++currentStep.value;

        var currWizardStep = $('.bs-wizard-step')[currentStep.value];
        $(currWizardStep).removeClass('disabled');
        $(currWizardStep).addClass('active');

        sessionStorage.setItem('currentStep', currentStep.value);
        showStep(steps, currentStep.value);
        toggleStepBtnVisibility(newTournamentForm);
    };

    var partChoiseChbx = document.querySelectorAll('.part-choice');
    for (var i = 0; i < partChoiseChbx.length; ++i) {
        var partChbx = partChoiseChbx[i].querySelectorAll('input[type=checkbox]');
        for (var j = 0; j < partChbx.length; ++j) {
            partChbx[j].onclick = function () {
                var partName = this.value.split('_')[1];
                console.log(partName + ' checked');
                togglePartSettingsVisibility(partName);
            }
        }
    }
}

var editTournament = document.getElementById('edit-tournament');
if (editTournament) {
  var currentStep = editTournament.querySelector('#step');
  var steps = editTournament.querySelectorAll('.creation-step');
  var nextStepBtn = editTournament.querySelector('#next-step');
  var prevStepBtn = editTournament.querySelector('#prev-step');
  var saveBtn = editTournament.querySelector('#save');

  showStep(steps, currentStep.value);
  toggleStepBtnVisibility(editTournament);
  var wizardSteps = document.querySelectorAll('.bs-wizard-step');
  for(var i = 0; i < wizardSteps.length; ++i) {
    $(wizardSteps[i]).click(function () {
      var w = Array.prototype.slice.call($('.bs-wizard-step'));
      var step = w.indexOf(this);
      if (!$(this).hasClass('disabled')) {
        currentStep.value = step;
        showStep(steps, step);
        toggleStepBtnVisibility(editTournament);
      }
    });

    toggleWizardSteps(currentStep.value);
  }

  prevStepBtn.onclick = function () {
    var prevWizardStep = $('.bs-wizard-step')[currentStep.value];
    $(prevWizardStep).removeClass('active');
    $(prevWizardStep).addClass('disabled');

      --currentStep.value;

      var currWizardStep = $('.bs-wizard-step')[currentStep.value];
      $(currWizardStep).removeClass('complete');
      $(currWizardStep).addClass('active');

      sessionStorage.setItem('currentStep', currentStep.value);
      showStep(steps, currentStep.value);
      toggleStepBtnVisibility(editTournament);
  };

  nextStepBtn.onclick = function () {
    var currentStepDiv = $('.creation-step')[currentStep.value];
    var currentStepFields = $(currentStepDiv).find('.form-control');
    for(var i = 0; i < currentStepFields.length; ++i) {
      if (!currentStepFields[i].value) {
        console.log('not all fields are filled!');
        $('#error').html('<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><span>Заполните все поля!</span></div>');
        return;
      }
    }

    var prevWizardStep = $('.bs-wizard-step')[currentStep.value];
    $(prevWizardStep).removeClass('active');
    $(prevWizardStep).addClass('complete');

      ++currentStep.value;

      var currWizardStep = $('.bs-wizard-step')[currentStep.value];
      $(currWizardStep).removeClass('disabled');
      $(currWizardStep).addClass('active');

      sessionStorage.setItem('currentStep', currentStep.value);
      showStep(steps, currentStep.value);
      toggleStepBtnVisibility(editTournament);
  };
}


var addSquadBtn = document.getElementById('add-squad');
var squadsCount = document.getElementById('squads-count');
addSquadBtn.onclick = function () {
    var xhr = new XMLHttpRequest();
    var params = '?' + 'index=' + (++squadsCount.value);

    xhr.open('GET', '/addSquadForm' + params, false);
    xhr.send();

    if (xhr.status != 200) {
        console.log(xhr.responseText);
    }
    else {
        $(this).parent().append(xhr.responseText);
        console.log(squadsCount.value);
    }
};

var removeSquadBtns = document.querySelectorAll('.remove-squad');
for (var i = 0; i < removeSquadBtns.length; ++i) {
    removeSquadBtns[i].onclick = function () {
        removeSquad(this);
    }
}

function removeSquad(squad) {
    $(squad).parent().remove();
    $('#squads-count').val($('#squads-count').val() - 1);
    // --squadsCount.value;
}

function showStep(steps, step) {
    for (var i = 0; i < steps.length; ++i) {
        steps[i].hidden = (i != step);
    }
}

function toggleWizardSteps(currentStep) {
  for (var i = 0; i < wizardSteps.length; ++i) {
    if(i == currentStep) {
      $(wizardSteps[i]).removeClass('complete');
      $(wizardSteps[i]).removeClass('disabled');
      $(wizardSteps[i]).addClass('active');
    }
    else if (i < currentStep) {
      $(wizardSteps[i]).removeClass('disabled');
      $(wizardSteps[i]).removeClass('active');
      $(wizardSteps[i]).addClass('complete');
    }
    else {
      $(wizardSteps[i]).removeClass('complete');
      $(wizardSteps[i]).removeClass('active');
      $(wizardSteps[i]).addClass('disabled');
    }
  }
}

function toggleStepBtnVisibility(form, isNew) {
    var currentStep = form.querySelector('#step').value;
    var steps = form.querySelectorAll('.creation-step');
    var nextStepBtn = form.querySelector('#next-step');
    var prevStepBtn = form.querySelector('#prev-step');
    var saveBtn = form.querySelector('#save');

    if (currentStep == 0) {
      $(prevStepBtn).hide();
    }
    else {
      $(prevStepBtn).show();
      // $(saveBtn).show();
    }
    (currentStep == steps.length - 1) ? $(nextStepBtn).hide() : $(nextStepBtn).show();
    if (isNew) {
      (currentStep != steps.length - 1) ? $(saveBtn).hide() : $(saveBtn).show();
    }
    else {
      $(saveBtn).show();
    }
}

function togglePartSettingsVisibility(partName) {
    var partBlock = document.getElementsByClassName(partName)[0];
    partBlock.hidden = !(partBlock.hidden);
}
