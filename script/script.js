
let taskform = document.querySelector('form');
let todoList = document.getElementById('todo-list');
let doneList = document.getElementById('done-list');
let deleteBtn = document.getElementsByClassName('delete');
let previousValues = [];


taskform.addEventListener('submit', function(e){
    e.preventDefault();
    let p = document.createElement("p");
    let task = document.getElementById("task").value;
    let deleteButton = document.createElement("button");
    let finishedButton = document.createElement("button");
    deleteButton.setAttribute("class", "delete");
    deleteButton.innerHTML = "❌";
    finishedButton.innerHTML = "✔️";
    finishedButton.setAttribute("class", "finished");
    if(task != "" && !previousValues.includes(task)){
        previousValues.push(task);
        p.innerHTML = task;
        p.appendChild(deleteButton);
        p.appendChild(finishedButton);
        todoList.appendChild(p);
    }
});

todoList.addEventListener('click', function(e){
    let btn = e.target;
    if(btn.classList.contains("delete")){
        e.preventDefault();
        let el = btn.parentNode;
        let key = previousValues.indexOf(el.innerText.slice(0, -3));
        if (key > -1) {
        previousValues.splice(key, 1);
        }
        el.remove();
    }
    else if(btn.classList.contains("finished")){
        e.preventDefault();
        let el = btn.parentNode;
        btn.remove();
        doneList.insertAdjacentElement('afterbegin', el);
    }
});

doneList.addEventListener('click', function(e){
    let btn = e.target;
    if(btn.classList.contains("delete")){
        e.preventDefault();
        let el = btn.parentNode;
        let key = previousValues.indexOf(el.innerText.slice(0, -1));
        if (key > -1) {
        previousValues.splice(key, 1);
        }
        el.remove();
    }
});

