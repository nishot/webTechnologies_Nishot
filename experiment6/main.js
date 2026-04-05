const signupbtn=document.getElementById('signup')
const loginbtn=document.getElementById('login')

const loginpage=document.getElementById('form_main_login')
const signuppage=document.getElementById('form_main_sign_up')

signupbtn.onclick=function(){
signuppage.style.display='block'
loginpage.style.display='none'
}

loginbtn.onclick=function(){
loginpage.style.display='block'
signuppage.style.display='none'
}

const form=document.getElementById("signupform")

const fullName=form.querySelector('input[type="text"]')
const email=form.querySelector('input[type="email"]')
const password=form.querySelector('input[type="password"]')
const select=document.getElementById("exerciseLevel")
const terms=form.querySelector('input[type="checkbox"]')

function display(){

const gender=document.querySelector('input[name="gender"]:checked')

let g=""

if(gender){
g=gender.value
}

document.getElementById('display').innerText=
"Name: "+fullName.value+
"\nEmail: "+email.value+
"\nGender: "+g+
"\nLevel: "+select.value+
"\nTerms: "+terms.checked

}

function login(){

const form=document.getElementById("loginform")

const email=form.querySelector('input[type="email"]')
const password=form.querySelector('input[type="password"]')

document.getElementById('display').innerText=
"Login Email: "+email.value

}