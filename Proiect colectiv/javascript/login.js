const form = document.querySelector(".login form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-text");

form.onsubmit = (e)=>{
    e.preventDefault();
}

continueBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/login.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let data = xhr.response;
              if(data === "success"){
                //location.href = "profile.php";
                location.href = "feed.php";
              }else{
                errorText.style.display = "block";
                errorText.textContent = data;
              }
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}

// Selectează butonul "Continue to Feed"
const continueFeedBtn = document.querySelector(".button-feed input");

// Atașează un eveniment onclick pentru butonul "Continue to Feed"
continueFeedBtn.onclick = () => {
  // Crează o cerere HTTP GET către feed.html
  window.location.href = "feed.html";
}