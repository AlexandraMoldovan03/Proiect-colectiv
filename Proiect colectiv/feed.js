const menuItems = document.querySelectorAll('.menu-item');

const theme = document.querySelector('#theme');
const themeModal = document.querySelector('.customize-theme');
const fontSizes = document.querySelectorAll('.choose-size span');
var root = document.querySelector(':root');
const colorPallette = document.querySelectorAll('.choose-color span')
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
    if(e.target.classList.contains('customize-theme')){
        themeModal.style.display = 'none';
    }
};

theme.addEventListener('click', openThemeModal);
themeModal.addEventListener('click', closeThemeModal); // Add this line

const removeSizeSelector = () =>{
    fontSizes.forEach(size => {
        size.classList.remove('active');
    })
}


fontSizes.forEach(size => {
   
    size.addEventListener('click', () => {

        removeSizeSelector();
        let fontSize;
        size.classList.toggle('active');
    
        if(size.classList.contains('font-size-1')){
            fontSize = '10px';
            root.style.setProperty('--sticky-top-left', '5.4rem'); // Correct syntax
            root.style.setProperty('--sticky-top-right', '5.4rem'); // Correct syntax
        } else if(size.classList.contains('font-size-2')){
            fontSize = '13px';
            root.style.setProperty('--sticky-top-left', '5.4rem'); // Correct syntax
            root.style.setProperty('--sticky-top-right', '-7rem'); // Correct syntax
        } else if(size.classList.contains('font-size-3')){ 
            fontSize = '16px';
            root.style.setProperty('--sticky-top-left', '-2rem'); // Correct syntax
            root.style.setProperty('--sticky-top-right', '-17rem'); // Correct syntax
        } else if(size.classList.contains('font-size-4')){
            fontSize = '19px';
            root.style.setProperty('--sticky-top-left', '-5rem'); // Correct syntax
            root.style.setProperty('--sticky-top-right', '-25rem'); // Correct syntax
        } else if(size.classList.contains('font-size-5')){
            fontSize = '22px';
            root.style.setProperty('--sticky-top-left', '-10rem'); // Correct syntax
            root.style.setProperty('--sticky-top-right', '-33rem'); // Correct syntax
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
        }else if (color.classList.contains('color-3')) {
            mainColor = 'var(--color-beach)';
            primaryColor = 'var(--color-blue)';
            secondaryColor = 'var(--color-darkblue)';
            thirdColor = 'var(--color-pastel)';
        }else if (color.classList.contains('color-4')) {
            mainColor = 'var(--color-watermelon)';
            primaryColor = 'var(--color-pinky)';
            secondaryColor = 'var(--color-greenw)';
            thirdColor = 'var(--color-pinkw)';
        }else if (color.classList.contains('color-5')) {
            mainColor = 'var(--color-city)';
            primaryColor = 'var(--color-bleu)';
            secondaryColor = 'var(--color-PINK)';
            thirdColor = 'var(--color-yellow)';
        }    
        // Add more conditions for other colors/themes

        color.classList.add('active');

        root.style.setProperty('--main-color', mainColor);
        root.style.setProperty('--primary-color', primaryColor);
        root.style.setProperty('--secondary-color', secondaryColor);
        root.style.setProperty('--third-color', thirdColor);
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const profileLink = document.getElementById('profileLink');
    
    if (profileLink) {
        profileLink.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent default link behavior

            // Redirect to profile.html
            window.location.href = 'profil.html';
        });
    }
});

document.getElementById('createPostBtn').addEventListener('click', function() {
            document.querySelector('.create-post').style.display = 'block';
        });

        // Handle form submission to create a new post
        document.getElementById('postForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Get the post content from the textarea
            let postContent = document.getElementById('postContent').value.trim();

            // Check if the post content is not empty
            if (postContent !== '') {
                // Create a new post element
                let newPost = document.createElement('div');
                newPost.classList.add('feed');
                newPost.innerHTML = `
                    <!-- Your post structure here -->
                    <div class="head">
                        <!-- Post header content -->
                    </div>
                    <div class="photo">
                        <!-- Post photo content -->
                    </div>
                    <div class="action-button">
                        <!-- Action buttons -->
                    </div>
                    <div class="liked-by">
                        <!-- Liked by content -->
                    </div>
                    <div class="caption">
                        <p><b>Username:</b> ${postContent}</p>
                    </div>
                    <div class="comments text-muted">
                        <!-- Comments content -->
                    </div>
                `;

                // Append the new post to the feeds container
                document.querySelector('.feeds').prepend(newPost);

                // Reset the form and hide the posting form
                document.getElementById('postContent').value = '';
                document.querySelector('.create-post').style.display = 'none';
            } else {
                alert('Please enter something to post.');
            }
        });