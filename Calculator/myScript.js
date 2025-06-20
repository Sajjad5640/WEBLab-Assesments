function Solve(val) {
    var v = document.getElementById('display');
    v.value += val;
 }
 function Result() {
    var num1 = document.getElementById('display').value;
    try {
       var num2 = eval(num1.replace('x', '*'));
       document.getElementById('display').value = num2;
    } catch {
       document.getElementById('display').value = 'Error';
    }
 }
 document.addEventListener('keydown', function (event) {
    const key = event.key;
    const validKeys = '0123456789+-*/.%';
    if (validKeys.includes(key)) {
       Solve(key === '*' ? 'x' : key);
    } else if (key === 'Enter') {
       Result();
    } else if (key === 'Backspace') {
       Back();
    } else if (key.toLowerCase() === 'c') {
       Clear();
    }
 });