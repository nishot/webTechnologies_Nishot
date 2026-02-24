let operation="";
function appender(numoper){
    operation+=numoper;
    console.log(operation)
}
function display(){
    let dis=operation
    document.getElementById('result').innerHTML=dis;
}
function resclear(){
    operation="";
    document.getElementById('result').innerHTML=operation;
}
function calculate(){
    let result=eval(operation);
    document.getElementById('result').innerHTML=result;
    operation="";
}
