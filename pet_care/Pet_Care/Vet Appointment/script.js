$(document).ready(function () {
    function fetchBookedDates() {
        $.ajax({
            type: 'GET',
            url: 'getAppointment.php',
            dataType: 'json',
            success: function (data) {
                $('#appointmentDate').datepicker({
                    beforeShowDay: function (date) {
                        var dateString = $.datepicker.formatDate('yy-mm-dd', date);
                        if (data.includes(dateString)) {
                            return [false, 'fully-booked', 'All slots booked for this date'];
                        } else {
                            return [true, '', ''];
                        }
                    },
                    minDate: 0,
                    maxDate: '+2M', // Set maximum date to current date + 2 months
                    dateFormat: 'yy-mm-dd'
                });
                $('#appointmentDate').removeAttr('readonly'); // Ensure appointment date field is not readonly
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    fetchBookedDates(); // Fetch booked dates on document ready

    $('#registrationForm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
        formData.push({ name: "petType", value: $('#petType').val() });
        $.ajax({
            type: 'POST',
            url: 'connect.php',
            data: formData,
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    displaySuccessMessage();
                    fetchBookedDates(); // Refresh booked dates after successful submission
                } else {
                    console.error('Error in form submission');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    function displaySuccessMessage() {
        var successMessage = '<div class="alert alert-success" role="alert">Data stored successfully!</div>';
        $('#registrationForm').append(successMessage);
    }

    // Ensure time select is not readonly
    $('#appointmentTime').removeAttr('readonly');

    function validateDate() {
        const selectedDate = new Date(document.getElementById('appointmentDate').value);
        const today = new Date();
        const maxAllowedDate = new Date(today.getFullYear(), today.getMonth() + 1, today.getDate()); // Next month

        if (selectedDate > maxAllowedDate) {
            alert('Please choose a date within the current month and the next month.');
            document.getElementById('appointmentDate').value = ''; // Clear the selected date
        }
    }

    // Show Appointments function
    function showAppointments() {
        window.location.href = 'my-appointments.html';
    }
});
