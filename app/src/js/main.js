const petDetectrApp = petDetectrApp || {};

petDetectrApp.formSetup = function formSetup(formName = 'report_form') {
    // Pet info
    this.petStatusInput = document[formName].status;

    // Toggle fields
    this.toggleTriggerFields = document[formName].getElementsByClassName('js-field-toggle-trigger');

    // Required fields
    this.requiredFields = document[formName].getElementsByClassName('js-required-field');


    // Grab radio buttons and text nodes
    this.lastSeenText = document.querySelectorAll('.js-seen-found-text');


    this.addEventToNodes('click', this.petStatusInput, this.updateDateAndLocationText);
    this.addEventToNodes('click', this.toggleTriggerFields, this.toggleFieldVisibility);

    // Basic required validation
    this.addEventToNodes('blur', this.requiredFields, this.validateRequired);
    this.addEventToNodes('focus', this.requiredFields, this.clearValidationIndicators);
};

petDetectrApp.clearValidationIndicators = function clearValidationIndicators(e) {
    e.target.classList.remove('is-invalid');
    petDetectrApp.setHideShow(e.target.nextElementSibling, false);
};

petDetectrApp.validateRequired = function validateRequired(e) {
    if (e.target.value === '') {
        e.target.classList.add('is-invalid');
        petDetectrApp.setHideShow(e.target.nextElementSibling, true);
    }
};

petDetectrApp.updateDateAndLocationText = function updateDateAndLocationText(e) {
    const currentStatus = e.target.value;
    let lastSeenValue = '';

    if (currentStatus === 'lost') {
        lastSeenValue = 'last seen';
    } else if (currentStatus === 'found') {
        lastSeenValue = 'found';
    } else {
        lastSeenValue = 'reported';
    }

    // updates all the text nodes
    for (let i = 0, max = petDetectrApp.lastSeenText.length; i < max; i++) {
        petDetectrApp.lastSeenText[i].innerHTML = lastSeenValue;
    }
};

// Add listener to nodes
petDetectrApp.addEventToNodes = function addEventToNodes(evt, nodes, func) {
    for (let i = 0; i < nodes.length; i++) {
        nodes[i].addEventListener(evt, func, true);
    }
};

// Set the use of h-hide class on target
petDetectrApp.setHideShow = function showHideElement(target, display) {
    if (display) {
        target.classList.remove('h-hide');
    } else {
        target.classList.add('h-hide');
    }
};

// Chip number h-hide switching
petDetectrApp.toggleFieldVisibility = function toggleFieldVisibility(e) {
    // get data attributes
    const radioToggleTarget = document.getElementById(e.target.dataset.toggleTarget);
    const radioToggleVisibility = e.target.dataset.toggleTargetVisibility;

    petDetectrApp.setHideShow(radioToggleTarget, radioToggleVisibility);
};


petDetectrApp.fileUpload = () => {

    // set up vars for dom nodes to be changed
    const input   = document.getElementById('jsonResponseFile');
    const form    = document.getElementById('upload_form');
    const title   = document.getElementById('form_title');
    const label   = document.getElementById('label_text');
    const spinner = document.getElementById('spinner');

    input.addEventListener('change', function(e)
    {
        // retrieve filename of selected file
        var fileName = e.target.value.split( '\\' ).pop();

        // update dom elements with loading state
        label.innerHTML = fileName;
        spinner.classList.remove('h-hide');
        choose_file.classList.add('h-hide');
        form_title.innerHTML = 'Uploading…';

    });


}

petDetectrApp.formSetup();
petDetectrApp.fileUpload();
