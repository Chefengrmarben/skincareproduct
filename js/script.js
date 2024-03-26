let navbar = document.querySelector('.header .flex .navbar');


document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   profile.classList.remove('active');
}

let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   navbar.classList.remove('active');
}

window.onscroll = () =>{
   profile.classList.remove('active');
   navbar.classList.remove('active');
}

/* forget password */

document.getElementById('forgotPasswordForm').addEventListener('submit', function(event) {
   event.preventDefault();

   var email = document.getElementById('email').value;

   var xhr = new XMLHttpRequest();
   xhr.open('POST', 'sendEmail.php', true);
   xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
   xhr.onreadystatechange = function() {
       if (xhr.readyState == 4 && xhr.status == 200) {
           alert('Please check your email for a link to reset your password.');
       }
   }
   xhr.send('email=' + encodeURIComponent(email));
});



/* order button */
document.addEventListener('DOMContentLoaded', function (){
   var orderButton = document.getElementById('order-btn');

   if(orderButton){
      orderButton.addEventListener('click', function(){
         if(!orderButton.classList.contains('disabled')){
            alert('Order Placed!');
         }else{
            alert('cannot place order. Cart total is less than 1')
         }
      })
   }
})

