/* Timer mechanism */
var minutesVar = 25;
var secondsVar = 00;
const timerUp = document.getElementById("iconTimerUp");
const timerDown = document.getElementById("iconTimerDown");
const startBtn = document.getElementById("startBtn");

/* Increase minutes on click on button */
timerUp.onclick = function increaseTimer() {
    minutesVar++;
    document.getElementById("minutesVar").innerHTML = minutesVar;
};

/* Decrease minutes on click on button */
timerDown.onclick = function decreaseTimer() {
    /* Check if munites is not less than 0 */
    if (minutesVar <= 0) {
      console.log("Value can not be less than 0");
    }
    else {
    minutesVar--;
    document.getElementById("minutesVar").innerHTML = minutesVar;
    }
};

/* Change Start-Stop button on click and start or stop the timer */
startBtn.onclick = function timer() {
    if (startBtn.id == "startBtn"){
        startBtn.innerHTML = "Stop";
        startBtn.setAttribute("id", "stopBtn");
        startTimer();
    } else {
        stopTimer();
        startBtn.innerHTML = "Start";
        startBtn.setAttribute("id", "startBtn");
    }
};

/* Start the timer to count down */
function startTimer() {

    let self = this;
    /* Stop timer when it reaches 00:00 */
    this.timer = setInterval(() => {
        if (countDown() == true) {
            clearInterval(self.timer);
        }
    }, 1000);
};

/* Stop the timer and get it back to the starting values */
function stopTimer() {
        clearInterval(self.timer);
        minutesVar = 25;
        secondsVar = 00;
        document.getElementById("minutesVar").innerHTML = minutesVar;
        document.getElementById("secondsVar").innerHTML = "0" + secondsVar;
};

/* Change the timer values and show them */
function countDown() {
    if (secondsVar === 0){
        minutesVar--;
        document.getElementById("minutesVar").innerHTML = minutesVar;
        secondsVar = 60;
    }
    secondsVar--;
    document.getElementById("secondsVar").innerHTML = secondsVar;

    if (secondsVar < 10) {
        document.getElementById("secondsVar").innerHTML = "0" + secondsVar;
    }
    if (minutesVar <= 0 && secondsVar <= 0) {
        return true;
    }
    return false;
};



/* To-do list mechanism */

function addCookie(name, value) {
    document.cookie = name + "=" + value + "; path=/";
}

/* Hide the current list item on close button click */
var close = document.getElementsByClassName("close");
for (var i = 0; i < close.length; i++) {
  close[i].onclick = function() {
    var div = this.parentElement;
    div.style.display = "none";
  }
}

/* Change item to checked */
var list = document.querySelector("ul");
list.addEventListener("click", function(ev) {
  if (ev.target.tagName === "LI") {
    ev.target.classList.toggle("checked");
  }
}, false);

/* Add new item to toDo list */
document.getElementsByClassName("addTick")[0].onclick = function newElement() {
    var li = document.createElement("li");
    var newText = document.createTextNode(document.getElementsByClassName("addNewTask")[0].value);

    li.appendChild(newText);
    document.getElementsByClassName("toDoList")[0].appendChild(li);
    document.getElementsByClassName("addNewTask")[0].value = "";
    
    var span = document.createElement("SPAN");
    var deleteSign = document.createTextNode(" X");
    span.className = "close";
    span.appendChild(deleteSign);
    li.appendChild(span);
    
    for (var i = 0; i < close.length; i++) {
        close[i].onclick = function() {
            var div = this.parentElement;
            div.style.display = "none";
        }
    }
};

var elems = [];
var todos = list.children;
var saveBtn = document.getElementById("save-btn");
 
/**
 * Class Todo for saving it to JSON and sending to backend
 * Text - text of Todo
 * State - true, if Todo completed, otherwise - false
 */
class Todo {
    text = null
    state = false

    constructor(text, state){
        this.text = text
        this.state = state
    }
}

/* Save data to cookie on click */
saveBtn.onclick = function saveDataToCookie() {
    for (var i = 0; i < todos.length; i++) {
        if (todos[i].style.display != "none"){
            todo = new Todo(todos[i].childNodes[0].data, todos[i].classList.contains("checked"));
            elems.push(todo);
        }
    }
    addCookie("doneTask",JSON.stringify(elems));
    addCookie("isAlt", true);
}
