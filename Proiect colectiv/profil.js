const root = document.querySelector(':root'); // Add this line to access root variables

// Retrieve theme colors from localStorage
const mainColor = localStorage.getItem('mainColor');
const primaryColor = localStorage.getItem('primaryColor');
const secondaryColor = localStorage.getItem('secondaryColor');
const thirdColor = localStorage.getItem('thirdColor');

// Apply theme colors to root variables if retrieved from localStorage
if (mainColor && primaryColor && secondaryColor && thirdColor) {
    root.style.setProperty('--main-color', mainColor);
    root.style.setProperty('--primary-color', primaryColor);
    root.style.setProperty('--secondary-color', secondaryColor);
    root.style.setProperty('--third-color', thirdColor);
}

function editProfile() {
    document.getElementById('profileForm').style.display = 'block';
    document.querySelector('.profile').style.display = 'none';
}

function cancelEdit() {
    document.getElementById('profileForm').style.display = 'none';
    document.querySelector('.profile').style.display = 'block';
}

    function saveProfile() {
        var formData = new FormData(document.getElementById('editProfileForm'));
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_profile.php', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Handle success response
                console.log(xhr.responseText); // Log response for debugging
                // You can add code here to update the UI if needed
            } else {
                // Handle error response
                console.error('Error occurred.');
            }
        };
        xhr.send(formData);
    }

