import * as svg from './bootstrap/js/svg.js';

let placeRenderingWindows = document.getElementById('placeRenderingWindows');
let shadow = document.getElementById('shadow');
let taskList = document.getElementById('taskList');

export default class Render {
    task(obj) {
        let container = document.createElement('div');
        let containerCheckbox = document.createElement('div');
        let checkbox = document.createElement('input');
        let titleTask = document.createElement('span');
        let containerOption = document.createElement('div');

        let taskPriority = document.createElement('span');
        let btnEditTask = document.createElement('button');

        btnEditTask.className = 'btn priority d-flex justify-content-end';

        btnEditTask.innerHTML = svg.bi_pencil_square;

        taskPriority.className = 'text-white px-1 d-flex justify-content-end mr-1';
        taskPriority.innerHTML = obj.priorityTitle;

        if (Number(obj.status)) {
            checkbox.checked = true;
            container.className = 'bg-secondary';
            titleTask.style.textDecoration = 'line-through';
        } else {
            checkbox.checked = false;
            container.className = 'bg-dark';
        }

        containerOption.className = 'position-absolute edit-task d-flex justify-content-center align-items-center';

        titleTask.className = 'd-flex align-items-center';
        titleTask.innerText = obj.title;

        checkbox.type = 'checkbox';

        containerCheckbox.className = 'd-flex justify-content-center align-items-center position-relative';
        containerCheckbox.style.width = '40px';

        container.className += ' text-light col-12 d-flex p-0 rounded my-1';
        container.style.height = '40px';

        containerOption.append(taskPriority, btnEditTask);
        containerCheckbox.append(checkbox);
        container.append(containerCheckbox, titleTask, containerOption);
        taskList.append(container);

        return {
            btnEditTask,
            checkbox,
        }
    }

    windowNewTask(priorities) {
        let window = document.createElement('div');
        window.id = 'window';
        window.classList = 'container-sm windowEditTask';

        let col = document.createElement('div');
        col.classList = 'col-lg-5 bg-white mt-5 mx-5 p-2 rounded mx-auto position-relative window-add-notepad task';

        let h4 = document.createElement('h4');
        h4.innerText = 'Добавить задачу';

        let label = document.createElement('label');
        label.for = 'title';
        label.innerText = 'Задача';

        let inputTask = document.createElement('input');
        inputTask.classList = 'form-control';
        inputTask.id = 'title';
        inputTask.placeholder = 'Например: Купить что-то';

        let labelSelect = document.createElement('label');
        labelSelect.for = 'priority';
        labelSelect.innerText = 'Приоритет';

        let select = document.createElement('select');
        select.id = 'priority';
        select.classList = 'form-control';

        priorities.forEach((item, index) => {
            let option = document.createElement('option');
            option.value = item.id;
            option.innerText = item.title;
            select.append(option);
        });

        let buttonCloseWindow = document.createElement('button');
        buttonCloseWindow.classList = 'btn position-absolute';
        buttonCloseWindow.style = 'top: 4px; right: 4px';
        buttonCloseWindow.innerHTML = svg.bi_x_circle_fill;

        let buttonSave = document.createElement('button');
        buttonSave.classList = 'btn btn-primary col-12 mt-3';
        buttonSave.id = 'save';
        buttonSave.innerText = 'Сохранить';

        buttonCloseWindow.onclick = () => {
            window.remove();
            this.shadow();
        }

        col.append(h4, label, inputTask, labelSelect, select, buttonCloseWindow, buttonSave);
        window.append(col);
        placeRenderingWindows.append(window);

        this.shadow();

        return {
            buttonSave,
            inputTask,
            select,
            window,
        };
    }

    windowEditTask(obj, priorities) {
        let window = document.createElement('div');
        window.id = 'window';
        window.classList = 'container-sm windowEditTask';

        let col = document.createElement('div');
        col.classList = 'col-lg-5 bg-white mt-5 mx-5 p-2 rounded mx-auto position-relative window-add-notepad task';

        let h4 = document.createElement('h4');
        h4.innerText = 'Редактировать задачу';

        let label = document.createElement('label');
        label.for = 'title';
        label.innerText = 'Задача';

        let inputTask = document.createElement('input');
        inputTask.classList = 'form-control';
        inputTask.id = 'title';
        inputTask.placeholder = 'Например: Купить что-то';
        inputTask.value = obj.title;

        let labelSelect = document.createElement('label');
        labelSelect.for = 'priority';
        labelSelect.innerText = 'Приоритет';

        let select = document.createElement('select');
        select.id = 'priority';
        select.classList = 'form-control';

        priorities.forEach((item, index) => {
            let option = document.createElement('option');

            if (obj.priority == item.id) option.selected = true;

            option.value = item.id;
            option.innerText = item.title;
            select.append(option);
        });

        let buttonDelete = document.createElement('button');
        buttonDelete.classList = 'btn position-absolute';
        buttonDelete.style = 'top: 4px; right: 50px';
        buttonDelete.id = 'deleteTask';
        buttonDelete.innerHTML = svg.bi_trash_fill;

        let buttonCloseWindow = document.createElement('button');
        buttonCloseWindow.classList = 'btn position-absolute';
        buttonCloseWindow.style = 'top: 4px; right: 4px';
        buttonCloseWindow.innerHTML = svg.bi_x_circle_fill;

        let buttonSave = document.createElement('button');
        buttonSave.classList = 'btn btn-primary col-12 mt-3';
        buttonSave.id = 'save';
        buttonSave.innerText = 'Сохранить';

        buttonCloseWindow.onclick = () => {
            window.remove();
            this.shadow();
        }

        col.append(h4, label, inputTask, labelSelect, select, buttonCloseWindow, buttonDelete, buttonSave);
        window.append(col);
        placeRenderingWindows.append(window);

        this.shadow();

        return {
            buttonSave,
            buttonDelete,
            inputTask,
            select,
            window,
        };
    }

    shadow() {
        if (getComputedStyle(shadow).display === 'none') {
            shadow.style.display = 'block';
        } else {
            shadow.style.display = 'none';
        }
    }
}
