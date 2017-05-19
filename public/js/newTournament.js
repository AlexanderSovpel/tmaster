var newTournamentForm = document.getElementById('new-tournament');
if (newTournamentForm) {
    var currentStep = newTournamentForm.querySelector('#step');
    if (getCookie('currentStep') != undefined)
        currentStep.value = getCookie('currentStep');

    var steps = newTournamentForm.querySelectorAll('.creation-step');
    var nextStepBtn = newTournamentForm.querySelector('#next-step');
    var prevStepBtn = newTournamentForm.querySelector('#prev-step');
    var saveBtn = newTournamentForm.querySelector('#save');

    showStep(steps, currentStep.value);
    toggleStepBtnVisibility();

    prevStepBtn.onclick = function () {
        --currentStep.value;
        setCookie('currentStep', currentStep.value);
        showStep(steps, currentStep.value);
        toggleStepBtnVisibility();
    };

    nextStepBtn.onclick = function () {
        ++currentStep.value;
        setCookie('currentStep', currentStep.value);
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
}

function showStep(steps, step) {
    for (var i = 0; i < steps.length; ++i) {
        steps[i].hidden = (i != step);
    }
}

function toggleStepBtnVisibility() {
    var currentStep = newTournamentForm.querySelector('#step').value;
    var steps = newTournamentForm.querySelectorAll('.creation-step');
    var nextStepBtn = newTournamentForm.querySelector('#next-step');
    var prevStepBtn = newTournamentForm.querySelector('#prev-step');
    var saveBtn = newTournamentForm.querySelector('#save');

    (currentStep == 0) ? $(prevStepBtn).addClass('hidden') : $(prevStepBtn).removeClass('hidden');
    (currentStep == steps.length - 1) ? $(nextStepBtn).addClass('hidden') : $(nextStepBtn).removeClass('hidden');
    (currentStep != steps.length - 1) ? $(saveBtn).addClass('hidden') : $(saveBtn).removeClass('hidden');
}

function togglePartSettingsVisibility(partName) {
    var partBlock = document.getElementsByClassName(partName)[0];
    partBlock.hidden = !(partBlock.hidden);
}