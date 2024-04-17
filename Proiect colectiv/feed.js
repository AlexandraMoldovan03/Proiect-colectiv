const menuItems = document.querySelectorAll('.menu-item');

const theme = document.querySelector('#theme');
const themeModal = document.querySelector('.customize-theme');
const fontSizes = document.querySelectorAll('.choose-size span');
var root = document.querySelector(':root');
const colorPallette = document.querySelectorAll('.choose-color span')

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
            primaryColor = 'var(--color-darkblue)';
            secondaryColor = 'var(--color-blue)';
            thirdColor = 'var(--color-pastel)';
        }else if (color.classList.contains('color-4')) {
            mainColor = 'var(--color-watermelon)';
            primaryColor = 'var(--color-pinkw)';
            secondaryColor = 'var(--color-greenw)';
            thirdColor = 'var(--color-pinky)';
        }else if (color.classList.contains('color-5')) {
            mainColor = 'var(--color-city)';
            primaryColor = 'var(--color-bleu)';
            secondaryColor = 'var(--color-yellow)';
            thirdColor = 'var(--color-PINK)';
        }    
        // Add more conditions for other colors/themes

        color.classList.add('active');

        root.style.setProperty('--main-color', mainColor);
        root.style.setProperty('--primary-color', primaryColor);
        root.style.setProperty('--secondary-color', secondaryColor);
        root.style.setProperty('--third-color', thirdColor);
    });
});







