import fetchPost from './fetch.js';
import Render from "./render.js";

let Draw = new Render();
let taskList = document.getElementById('taskList');

export default class Task {
    notepadObj = [];
    priorities = [];

    openWindowNewTask() {
        let windowNewTask = Draw.windowNewTask(this.priorities);

        windowNewTask.buttonSave.addEventListener('click', () => {
            let title = windowNewTask.inputTask;
            let priority = windowNewTask.select;

            let obj = {
                title: title.value,
                priority: priority.value,
            }

            this.createTask(obj).then((data) => {
                if (data['response']) {
                    this.getTask();
                    windowNewTask.window.remove();
                    Draw.shadow();
                } else {
                    alert('Ошибка создания задачи');
                }
            });
        });
    }

    createTask(obj) {
        return fetchPost('task/create', {
            task: obj,
        });
    }

    getTask() {
        fetchPost('/task/get', {}).then((data) => {
            this.notepadObj = data['tasks'];
            this.sort('priority');
            this.sort('status');
            this.showTask();
            this.getPriorities();
        });
    }

    update(task) {
        return fetchPost('task/update', {task: task});
    }

    getPriorities() {
        fetchPost('priority/get', {}).then((data) => {
            this.priorities = data['priority'];
        });
    }

    showTask() {
        let self = this;
        taskList.innerHTML = '';

        this.notepadObj.forEach(function (item) {
            self.createBlockTask(item);
        });
    }

    deleteTask(id) {
        let conf = confirm('Удалить задачу?');

        if (conf) {
            fetchPost('task/delete', {
                id: this.notepadObj[id].id,
            }).then((data) => {
                if (data['response']) {
                    this.notepadObj.splice(id, 1);
                    this.sort('priority');
                    this.sort('status');
                    this.showTask();
                } else {
                    alert('Ошибка удаления');
                    return false;
                }
            });
        }

        return false;
    }

    changeStatus(id) {
        // В статусе задачи должно храниться число, либо валидировать на сервере
        return this.notepadObj[id].status = Number(!Number(this.notepadObj[id].status));
    }

    getIndex(id) {
        return this.notepadObj.findIndex(item => item.id == id);
    }

    createBlockTask(obj) {
        let task = Draw.task(obj);

        task.checkbox.addEventListener('click', () => {
            let index = this.getIndex(obj.id);

            if (this.changeStatus(index)) {
                this.update(this.notepadObj[index]);
                this.notepadObj.push(this.notepadObj[index]);
                this.notepadObj.splice(index, 1);
            } else {
                this.update(this.notepadObj[index]);
            }

            this.sort('priority');
            this.sort('status');
            this.showTask();
        });

        // Редактировать задачу
        task.btnEditTask.onclick = () => {
            let index = this.getIndex(obj.id);
            let windowEditTask = Draw.windowEditTask(this.notepadObj[index], this.priorities);

            // Кнопка сохранить задачу
            windowEditTask.buttonSave.addEventListener('click', () => {
                let title = windowEditTask.inputTask;
                let priority = windowEditTask.select;

                this.notepadObj[index].title = title.value;
                this.notepadObj[index].priority = priority.value;
                this.notepadObj[index].priorityTitle = priority[priority.selectedIndex].text;

                this.update(this.notepadObj[index]).then((data) => {
                    if (data['response']) {
                        windowEditTask.window.remove();
                        Draw.shadow();
                        this.sort('priority');
                        this.sort('status');
                        this.showTask();
                    } else {
                        alert('Ошибка редактирования');
                    }
                });
            });

            // Кнопка удалить задачу
            windowEditTask.buttonDelete.addEventListener('click', () => {
                windowEditTask.window.remove();
                Draw.shadow();
                this.deleteTask(index, false);
            })
        };
    }

    sort(property) {
        this.notepadObj.sort((prev, next) => {
            if (prev[property] < next[property]) return -1;
            if (prev[property] > next[property]) return 1;
        });
    }
}
