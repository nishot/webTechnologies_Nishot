const signupbtn=document.getElementById('signup');
const loginbtn=document.getElementById('login');


const loginpage=document.getElementById('form_main_login');
const signuppage=document.getElementById('form_main_sign_up');
const choose=document.getElementById('choose');



signupbtn.onclick = function() {
    signuppage.style.display = 'block'; 
    loginpage.style.display = 'none';     
};

loginbtn.onclick = function() {
    loginpage.style.display = 'block';  
    signuppage.style.display = 'none'; 
};



function validate() {

    const form = document.getElementById("signupform");

    const fullName = form.querySelector('input[type="text"]');
    const email = form.querySelector('input[type="email"]');
    const password = form.querySelector('input[type="password"]');
    const gender = form.querySelector('input[name="gender"]:checked');
    const select = document.getElementById("exerciseLevel");
    const terms = form.querySelector('input[type="checkbox"]');

    if (fullName.value.trim() === "") {
        alert("Full name required");
        return false;
    }

    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if (!emailPattern.test(email.value)) {
        alert("Enter valid email");
        return false;
    }

    if (password.value.length < 8) {
        alert("Password must be at least 8 characters");
        return false;
    }

    if (!gender) {
        alert("Select the gender");
        return false;
    }

    if (select.value === "") {
        alert("Select a car");
        return false;
    }

    if (!terms.checked) {
        alert("Accept Terms & Conditions");
        return false;
    }

    alert("Form submitted successfully!");
    return true;
}

function validateLogin() {

    const form = document.getElementById("loginform");

    const email = form.querySelector('input[type="email"]');
    const password = form.querySelector('input[type="password"]');

    if (email.value.trim() === "") {
        alert("Email is required");
        return false;
    }
    if (password.value.trim() === "") {
        alert("Password is required");
        return false;
    }

    
    alert("Login successful!");
    return true;
}