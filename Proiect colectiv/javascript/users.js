const searchBar = document.querySelector(".search input"),
searchIcon = document.querySelector(".search button"),
usersList = document.querySelector(".users-list");
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

document.addEventListener('DOMContentLoaded', function () {
  const menuItems = document.querySelectorAll('.menu-item'); // Move this line inside the DOMContentLoaded event

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

});

const profileLink = document.getElementById('profileLink');
    const messagesLink = document.getElementById('messagesLink');

    if (profileLink) {
        profileLink.addEventListener('click', function (event) {
            event.preventDefault();
            window.location.href = 'profil.php';
        });
    }

    if (homeLink) {
        homeLink.addEventListener('click', function (event) {
            event.preventDefault();
            window.location.href = 'feed.php';
        });
    }

searchIcon.onclick = ()=>{
  searchBar.classList.toggle("show");
  searchIcon.classList.toggle("active");
  searchBar.focus();
  if(searchBar.classList.contains("active")){
    searchBar.value = "";
    searchBar.classList.remove("active");
  }
}

searchBar.onkeyup = ()=>{
  let searchTerm = searchBar.value;
  if(searchTerm != ""){
    searchBar.classList.add("active");
  }else{
    searchBar.classList.remove("active");
  }
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/search.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          usersList.innerHTML = data;
        }
    }
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + searchTerm);
}

setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "php/users.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          if(!searchBar.classList.contains("active")){
            usersList.innerHTML = data;
          }
        }
    }
  }
  xhr.send();
}, 500);

