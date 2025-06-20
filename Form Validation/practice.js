// function myfunction(){
//            document.getElementById("demo").innerHTML = "Hello World";
//          }



// const cars = ["salam","Borkat","seli"];
// cars.push("selma");
// console.log(cars);
// JavaScript Fuction
// function myFunction(name, time){
//     console.log(name + " is sleeping from " + time +" pm");

// }
// myFunction("kalam", "10");
// myFunction("Ralam", "3");
// myFunction("baalam", "5");
// console.log("my name is jasim");/ 
// 
// let text = "Ahfahkjfhakjfhakjhfkjdahdfkjahkhfdlakjdfhalkjdfkla";
// console.log(text.length);
// let x = "Jhone";
// let y = new String("Jhone");
// console.log(typeof x);
// console.log(typeof y);
// console.log(x===y);
// const a = {
//     name: "Jhone",
//     districts:64,
// };
// const s = "Bangladesh";
// console.log();

// let str = "apple, Banana, Kiwi";
// console.log(str.slice(7,13));
// let x = 123;
// let newN = x.toString()


const form = document.getElementById('form');
const username = document.getElementById('username');
const email = document.getElementById('email');
const password = document.getElementById('password');
const password2 = document.getElementById('password2');

form.addEventListener('submit',e =>{
    e.preventDefault();

    validateInputs();
});
const setError = (element, message) => {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector('.error');
    
    errorDisplay.innerText = message;
    inputControl.classList.add('error');
    inputControl.classList.remove('successs');
}
const setSuccess = (element) => {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector('.error');
    
    errorDisplay.innerText = '';
    inputControl.classList.add('successs');
    inputControl.classList.remove('error');
}

const isvalidEmail = (email) => {
  
  const re =  /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
};

const validateInputs = () =>{
    const usernameValue = username.value.trim();
    const emailValue = email.value.trim();
    const passwordValue = password.value.trim();
    const password2Value = password2.value.trim();

    if (usernameValue === ''){
        setError(username,'Username is required');
    }else{
        setSuccess(username);
    }
    if (emailValue ===''){
        setError(email, 'Email is required');
    }else if (!isvalidEmail(emailValue)){
        setError(email, 'Not a valid email');
    }else {
        setSuccess(email);
    }

    if (passwordValue ===''){
        setError(password,'Password is required');
    }else if (passwordValue.length < 8){
        setError(password, 'Password must be at least 8 characters long');
    }else{
        setSuccess(password);
    }

    if (password2Value === '') {
        setError(password2, 'Please confirm your password');
    }else if (password2Value !== passwordValue){
        setError(password2, 'Passwords do not match');
    }
    else{
        setSuccess(password2);
    }

}
