$(document).ready(function () {

    $('#userForm').on('submit', function (event) {
        event.preventDefault();
        const formData = $(this).serialize();
        const actionUrl = $(this).attr('action');


        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            success: function (response) {

                try {
                    const data = JSON.parse(response);

                    if (data.success) {
                        alert("Data saved successfully");
                        if (actionUrl.includes('/create')) {
                            window.location.href = '/';
                        } else if (actionUrl.includes('/update')) {
                            location.reload();
                        }
                    } else {
                        alert('Error: ' + (data.message || data.error));
                    }
                } catch (e) {
                    console.error('Invalid JSON response:', response);
                    alert('An unexpected error occurred. Please try again.');
                }
            },
            error: function (xhr) {
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });


    window.confirmDelete = function (element) {
        const confirmed = confirm('Are you sure you want to delete this user?');
        return confirmed;
    };

    document.querySelectorAll('.delete-user').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            const userId = this.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this user?')) {
                fetch(`/delete?id=${userId}`, {
                    method: 'GET'
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('User deleted successfully.');
                            location.reload();
                        } else {
                            alert('Error: ' + (data.error || 'Unable to delete user.'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An unexpected error occurred. Please try again.');
                    });
            }
        });
    });


    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('userForm');
        const inputs = form.querySelectorAll('input[required], select[required]');

        inputs.forEach((input) => {
            input.addEventListener('input', () => {
                if (input.checkValidity()) {
                    input.style.border = '';
                    input.style.boxShadow = '';
                } else {
                    input.style.border = '2px solid red';
                    input.style.boxShadow = '0 0 5px rgba(255, 0, 0, 0.5)';
                }
            });
        });
    });
});