var newTournamentForm = document.getElementById('new-tournament');
if (newTournamentForm) {
    var currentStep = newTournamentForm.querySelector('#step');
    if (sessionStorage.getItem('currentStep'))
        currentStep.value = sessionStorage.getItem('currentStep');

    var steps = newTournamentForm.querySelectorAll('.creation-step');
    var nextStepBtn = newTournamentForm.querySelector('#next-step');
    var prevStepBtn = newTournamentForm.querySelector('#prev-step');
    var saveBtn = newTournamentForm.querySelector('#save');

    showStep(steps, currentStep.value);
    toggleStepBtnVisibility();
    var wizardSteps = document.querySelectorAll('.bs-wizard-step');
    for(var i = 0; i < wizardSteps.length; ++i) {
      // $(wizardSteps[i]).click(function () {
      //   var w = Array.prototype.slice.call($('.bs-wizard-step'));
      //   var step = w.indexOf(wizardSteps[i]);
      //   showStep(steps, step);
      //   toggleStepBtnVisibility();
      //   toggleWizardSteps(step);
      //   currentStep.value = step;
      // });

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
        toggleStepBtnVisibility();
    };

    nextStepBtn.onclick = function () {
      var prevWizardStep = $('.bs-wizard-step')[currentStep.value];
      $(prevWizardStep).removeClass('active');
      $(prevWizardStep).addClass('complete');

        ++currentStep.value;

        var currWizardStep = $('.bs-wizard-step')[currentStep.value];
        $(currWizardStep).removeClass('disabled');
        $(currWizardStep).addClass('active');

        sessionStorage.setItem('currentStep', currentStep.value);
        showStep(steps, currentStep.value);
        toggleStepBtnVisibility();
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

    var addSquadBtn = document.getElementById('add-squad');
    var squadsCount = document.getElementById('squads-count');
    addSquadBtn.onclick = function () {
        var xhr = new XMLHttpRequest();
        var params = '?' + 'index=' + (++squadsCount.value);

        xhr.open('GET', '/addSquadForm' + params, false);
        xhr.send();

        if (xhr.status != 200) {
            document.getElementById('error').innerHTML = xhr.responseText;
        }
        else {
            $(this).after(xhr.responseText);
            console.log(squadsCount.value);
        }
    };

    var removeSquadBtns = document.querySelectorAll('.remove-squad');
    for (var i = 0; i < removeSquadBtns.length; ++i) {
        removeSquadBtns[i].onclick = function () {
            removeSquad(this);
        }
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

function toggleStepBtnVisibility() {
    var currentStep = newTournamentForm.querySelector('#step').value;
    var steps = newTournamentForm.querySelectorAll('.creation-step');
    var nextStepBtn = newTournamentForm.querySelector('#next-step');
    var prevStepBtn = newTournamentForm.querySelector('#prev-step');
    var saveBtn = newTournamentForm.querySelector('#save');

    (currentStep == 0) ? $(prevStepBtn).css('visibility', 'hidden') : $(prevStepBtn).css('visibility', 'visible');
    (currentStep == steps.length - 1) ? $(nextStepBtn).hide() : $(nextStepBtn).show();
    (currentStep != steps.length - 1) ? $(saveBtn).hide() : $(saveBtn).show();
}

function togglePartSettingsVisibility(partName) {
    var partBlock = document.getElementsByClassName(partName)[0];
    partBlock.hidden = !(partBlock.hidden);
}
