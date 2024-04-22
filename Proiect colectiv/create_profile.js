document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.getElementById('profileForm');
    const profilePictureInput = document.getElementById('profilePicture');
    const previewImg = document.getElementById('previewImg');

    profilePictureInput.addEventListener('change', function(event) {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImg.src = e.target.result;
            };

            reader.readAsDataURL(file);
        }
    });

    profileForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const profilePicture = profilePictureInput.files[0];
        const username = document.getElementById('username').value.trim();
        const hashtags = document.getElementById('hashtags').value.trim();

        if (profilePicture && username && hashtags) {
            alert('Profile created successfully! Redirecting...');
            window.location.href = 'profile.html';
        } else {
            alert('Please fill in all fields.');
        }
    });
});
