document.addEventListener('DOMContentLoaded', function () {
    const menuItems = document.querySelectorAll('.menu-item');

    const theme = document.querySelector('#theme');
    const themeModal = document.querySelector('.customize-theme');
    const fontSizes = document.querySelectorAll('.choose-size span');
    var root = document.querySelector(':root');
    const colorPallette = document.querySelectorAll('.choose-color span');
    const Bg1 = document.querySelector('.bg-1');
    const Bg2 = document.querySelector('.bg-2');

    const changeActiveItem = () => {
        menuItems.forEach(item => {
            item.classList.remove('active');
        });
    };

    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            changeActiveItem(); // Remove active class from all items
            item.classList.add('active'); // Add active class to the clicked item
        });
    });

    const openThemeModal = () => {
        themeModal.style.display = 'grid';
    };

    const closeThemeModal = (e) => {
        if (e.target.classList.contains('customize-theme')) {
            themeModal.style.display = 'none';
        }
    };

    theme.addEventListener('click', openThemeModal);
    themeModal.addEventListener('click', closeThemeModal);

    const removeSizeSelector = () => {
        fontSizes.forEach(size => {
            size.classList.remove('active');
        })
    }

    fontSizes.forEach(size => {
        size.addEventListener('click', () => {
            removeSizeSelector();
            let fontSize;
            size.classList.toggle('active');

            if (size.classList.contains('font-size-1')) {
                fontSize = '10px';
                root.style.setProperty('--sticky-top-left', '5.4rem');
                root.style.setProperty('--sticky-top-right', '5.4rem');
            } else if (size.classList.contains('font-size-2')) {
                fontSize = '13px';
                root.style.setProperty('--sticky-top-left', '5.4rem');
                root.style.setProperty('--sticky-top-right', '-7rem');
            } else if (size.classList.contains('font-size-3')) {
                fontSize = '16px';
                root.style.setProperty('--sticky-top-left', '-2rem');
                root.style.setProperty('--sticky-top-right', '-17rem');
            } else if (size.classList.contains('font-size-4')) {
                fontSize = '19px';
                root.style.setProperty('--sticky-top-left', '-5rem');
                root.style.setProperty('--sticky-top-right', '-25rem');
            } else if (size.classList.contains('font-size-5')) {
                fontSize = '22px';
                root.style.setProperty('--sticky-top-left', '-10rem');
                root.style.setProperty('--sticky-top-right', '-33rem');
            }

            document.querySelector('html').style.fontSize = fontSize;
        })
    })

    const changeActiveColorClass = () => {
        colorPallette.forEach(colorPicker => {
            colorPicker.classList.remove('active');
        })
    }

    colorPallette.forEach(color => {
        color.addEventListener('click', () => {
            let mainColor, primaryColor, secondaryColor, thirdColor;
            changeActiveColorClass();

            if (color.classList.contains('color-1')) {
                mainColor = 'var(--color-gradient)';
                primaryColor = 'var(--color-orange)';
                secondaryColor = 'var(--color-pink)';
                thirdColor = 'var(--color-green)';
            } else if (color.classList.contains('color-2')) {
                mainColor = 'var(--color-lavander)';
                primaryColor = 'var(--color-purple)';
                secondaryColor = 'var(--color-purpler)';
                thirdColor = 'var(--color-creamy)';
            } else if (color.classList.contains('color-3')) {
                mainColor = 'var(--color-beach)';
                primaryColor = 'var(--color-blue)';
                secondaryColor = 'var(--color-darkblue)';
                thirdColor = 'var(--color-pastel)';
            } else if (color.classList.contains('color-4')) {
                mainColor = 'var(--color-watermelon)';
                primaryColor = 'var(--color-pinky)';
                secondaryColor = 'var(--color-greenw)';
                thirdColor = 'var(--color-pinkw)';
            } else if (color.classList.contains('color-5')) {
                mainColor = 'var(--color-city)';
                primaryColor = 'var(--color-bleu)';
                secondaryColor = 'var(--color-PINK)';
                thirdColor = 'var(--color-yellow)';
            }

            color.classList.add('active');

            root.style.setProperty('--main-color', mainColor);
            root.style.setProperty('--primary-color', primaryColor);
            root.style.setProperty('--secondary-color', secondaryColor);
            root.style.setProperty('--third-color', thirdColor);

            // Store selected theme colors in localStorage
            localStorage.setItem('mainColor', mainColor);
            localStorage.setItem('primaryColor', primaryColor);
            localStorage.setItem('secondaryColor', secondaryColor);
            localStorage.setItem('thirdColor', thirdColor);
        });
    });

    // Retrieve theme colors from localStorage on page load
    const mainColor = localStorage.getItem('mainColor');
    const primaryColor = localStorage.getItem('primaryColor');
    const secondaryColor = localStorage.getItem('secondaryColor');
    const thirdColor = localStorage.getItem('thirdColor');

    if (mainColor && primaryColor && secondaryColor && thirdColor) {
        root.style.setProperty('--main-color', mainColor);
        root.style.setProperty('--primary-color', primaryColor);
        root.style.setProperty('--secondary-color', secondaryColor);
        root.style.setProperty('--third-color', thirdColor);
    }

    const profileLink = document.getElementById('profileLink');
    const messagesLink = document.getElementById('messagesLink');

    if (profileLink) {
        profileLink.addEventListener('click', function (event) {
            event.preventDefault();
            window.location.href = 'profil.html';
        });
    }

    if (messagesLink) {
        messagesLink.addEventListener('click', function (event) {
            event.preventDefault();
            window.location.href = 'users.php';
        });
    }

    document.getElementById('createPostBtn').addEventListener('click', function () {
        document.querySelector('.create-post').style.display = 'block';
    });

    document.getElementById('postForm').addEventListener('submit', function (event) {
        event.preventDefault();

        let postContent = document.getElementById('postContent').value.trim();

        if (postContent !== '') {
            let newPost = document.createElement('div');
            newPost.classList.add('feed');
            newPost.innerHTML = `
                <div class="head"></div>
                <div class="photo"></div>
                <div class="action-button"></div>
                <div class="liked-by"></div>
                <div class="caption">
                    <p><b>Username:</b> ${postContent}</p>
                </div>
                <div class="comments text-muted"></div>
            `;

            document.querySelector('.feeds').prepend(newPost);

            document.getElementById('postContent').value = '';
            document.querySelector('.create-post').style.display = 'none';
        } else {
            alert('Please enter something to post.');
        }
    });
});

