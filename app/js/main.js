import Task from './task.js';

let btnNewTask = document.getElementById('newTask');

let task = new Task();
task.getTask();

btnNewTask.onclick = () => task.openWindowNewTask();


