// function to set the minimum date for the end date of the tournament
// called when the start date is set
function setMinEndDate(date) {
    document.getElementById('endDate').min = date;
    document.getElementById('endDate').disabled = false;
}

// function to set the minimum value for the max age group for a tournament
// called when minimum age is set
function setMinMaxAge(age) {
    document.getElementById('maxAge').min = age;
}

// function to check if a text input is numeric using regular expressions
function checkNumeric(id) {
    var value = document.querySelector('#' + id).value;
    var regex = new RegExp('^[0-9]+$');
    if (!regex.test(value)) {
        return false;
    } else {
        return true;
    }
}


// var startDate = document.getElementById('startDate');
// var endDate = document.getElementById('endDate');
//
// if ((startDate && startDate.value) && (endDate && endDate.value)) {
//
// }


// CUSTOM VALIDATION THROUGH BOOTSTRAP
(function () {
    'use strict';
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if ((form.checkValidity() === false)) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

function setDayForm() {
    var startDate = new Date(document.getElementById("startDate").value);
    var endDate = new Date(document.getElementById("endDate").value);
    var rowString = "<div class='row'>";
    var startOrEnd;

    timediff = Math.abs(endDate.getTime() - startDate.getTime());
    var diffdays = Math.ceil(timediff / (1000 * 3600 * 24))
    for (i = 0; i <= diffdays; i++) {
        startOrEnd = 'start';

        rowString += "<div class='form-group col-md-2'><div class='input-label'>Day " + (i + 1) +
            "</div><input class='form-control'  type='time' name='day" + (i + 1) + startOrEnd +
            "' required>";
        startOrEnd = 'end';
        rowString += "<input class='form-control' type='time' name='day" + (i + 1) + startOrEnd +
            "' required></div>";


    }
    rowString += "</div>";

    document.getElementById('day-form').innerHTML = rowString;
}