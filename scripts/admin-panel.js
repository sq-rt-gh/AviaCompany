window.onload = () => GetData();


function Notify(text) {
    $("#toast").html(text);
    $("#toast").addClass("show");

    setTimeout(function(){
        $("#toast").removeClass("show");
    }, 4000);
}


function GetData() {
    $.ajax({
        url: "/php/admin-get.php",
        type: "GET",
        data: {
            table: $("#select").val()
        },
        success: (data) => {
            data = JSON.parse(data);

            if (data.table == "flights") {
                let minDate = new Date().toISOString().slice(0, -8); //yyyy-MM-ddThh:mm

                let planeSelect = "";
                data.planes.forEach(pl => {
                    planeSelect += `<option value="${pl.id}">${pl.model}</option>`;
                });

                $("#table").html(`<tr>
                    <th>Откуда</th><th>Куда</th><th>Отправление</th><th>Прибытие</th><th>Самолет</th><th colspan="2">Действие</th>
                    </tr>
                    <tr>
                    <td><input type="text" id="from" placeholder='Куда'></td>
                    <td><input type="text" id="to" placeholder='Откуда'></td>
                    <td><input type="datetime-local" id="dep" min="${minDate}"></td>
                    <td><input type="datetime-local" id="arr" min="${minDate}"></td>
                    <td><select id="plane"> <option disabled selected>--</option>
                    ${planeSelect}
                    </select></td>
                    <td colspan='2'><button onclick='AddFlight()' class='green'>Создать</button></td>
                    </tr>
                    <td colspan='7'><hr></td>`);

                data.flights.forEach(row => {
                    let planeSelect = "";
                    data.planes.forEach(pl => {
                        planeSelect += `<option value="${pl.id}" ${row.plane_id == pl.id ? "selected" : ""}>${pl.model}</option>`;
                    });

                    $("#table").append(`<tr id="tr${row.id}">
                        <td><input type="text" id="from${row.id}" value="${row.from}"></td>
                        <td><input type="text" id="to${row.id}" value="${row.destination}"></td>
                        <td><input type="datetime-local" id="dep${row.id}" value="${row.departure}" min="${minDate}"></td>
                        <td><input type="datetime-local" id="arr${row.id}" value="${row.arrival}" min="${minDate}"></td>
                        <td><select id="plane${row.id}"> <option disabled selected>--</option> ${planeSelect} </select></td>
                        <td>
                        <button onclick='SaveFlight(${row.id})' class='blue'>Сохранить</button>
                        </td>
                        <td>
                        <button onclick='DeleteFlight(${row.id})' class='red'>Удалить</button>
                        </td>
                        </tr>`);
                });
            }
            else if (data.table == "planes") {
                $("#table").html(`<tr><th>Модель</th><th>Картинка</th><th colspan="2">Действие</th></tr>
                    <tr>
                    <td><input type="text" id="model" placeholder='Модель'></td>
                    <td><input type="text" id="img" placeholder='Картинка'></td>
                    <td colspan='2'><button onclick='AddPlane()' class='green'>Создать</button></td>
                    </tr>
                    <td colspan='4'><hr></td>`);

                data.planes.forEach(row => {
                    $("#table").append(`<tr id="tr${row.id}">
                        <td><input type="text" id="model${row.id}" value="${row.model}"></td>
                        <td><input type="text" id="img${row.id}" value="${row.img}"></td>
                        <td><button onclick='SavePlane(${row.id})' class='blue'>Сохранить</button></td>
                        <td><button onclick='DeletePlane(${row.id})' class='red'>Удалить</button></td>
                        </tr>`);
                });
            }
            else if (data.table == "users") {
                $("#table").html(`<tr><th>Тип</th><th>Имя</th><th>Логин</th><th colspan="2">Действие</th></tr>
                    <tr>
                    <td> <select id="is_admin"> <option value="0">User</option> <option value="1">Admin</option> </select></td>
                    <td> <input type="text" id="name" placeholder='Имя'></td>
                    <td> <input type="text" id="login" placeholder='Логин'></td>
                    <td> <input type="text" id="pswd" placeholder='Пароль'></td>
                    <td> <button onclick='AddUser()' class='green'>Создать</button></td>
                    </tr>
                    <td colspan='5'><hr></td>`);

                data.users.forEach(row => {
                    let a = row.is_admin == '1' ? "selected" : "";
                    $("#table").append(`<tr id="tr${row.id}">
                    <td> <select id="is_admin${row.id}"><option value="0">User</option><option value="1" ${a}>Admin</option> </select></td>
                    <td> <input type="text" id="name${row.id}" value="${row.name}"></td>
                    <td> <input type="text" id="login${row.id}" value="${row.login}"></td>
                    <td> <button onclick='SaveUser(${row.id})' class='blue'>Сохранить</button></td>
                    <td> <button onclick='DeleteUser(${row.id})' class='red'>Удалить</button></td>
                    </tr>`);
                });
            }
        }
    });
}

// -----------------add-------------------

function AddFlight() {
    $.ajax({
        url: "/php/admin-new.php",
        type: "POST",
        data: {
            table: "flights",
            from: $("#from").val(),
            to: $("#to").val(),
            dep: $("#dep").val(),
            arr: $("#arr").val(),
            plane: $("#plane").val()
        },
        success: (data) => {
            data = JSON.parse(data);
            if (data.msg == "ok") {
                Notify(`Рейс '${data.from} &rarr; ${data.to}' добавлен!`);
                GetData();
            } else {
                Notify(data.msg);
            }
        }
    });
}

function AddPlane() {
    $.ajax({
        url: "/php/admin-new.php",
        type: "POST",
        data: {
            table: "planes",
            model: $("#model").val(),
            img: $("#img").val()
        },
        success: (data) => {
            data = JSON.parse(data);
            if (data.msg == "ok") {
                Notify(`Самолет '${data.model}' добавлен!`);
                GetData();
            } else {
                Notify(data.msg);
            }
        }
    });
}

function AddUser() {
    $.ajax({
        url: "/php/admin-new.php",
        type: "POST",
        data: {
            table: "users",
            name: $("#name").val(),
            login: $("#login").val(),
            pswd: $("#pswd").val(),
            is_admin: $("#is_admin").val()
        },
        success: (data) => {
            data = JSON.parse(data);
            if (data.msg == "ok") {
                Notify(`Пользователь '${data.user}' добавлен!`);
                GetData();
            } else {
                Notify(data.msg);
            }
        }
    });
}

// -----------------save-------------------

function SaveFlight(f_id) {
    $.ajax({
        url: "/php/admin-save.php",
        type: "POST",
        data: {
            table: "flights",
            id: f_id,
            from: $("#from" + f_id).val(),
            to: $("#to" + f_id).val(),
            dep: $("#dep" + f_id).val(),
            arr: $("#arr" + f_id).val(),
            plane: $("#plane" + f_id).val()
        },
        success: (data) => {
            data = JSON.parse(data);
            if (data.msg == "ok") {
                Notify(`Изменения сохранены!<br> Старые данные: ${data.from} | ${data.to} | ${data.dep} | ${data.arr} | ${data.model}`);
            } else {
                Notify(data.msg);
            }
        }
    });
}

function SavePlane(p_id) {
    $.ajax({
        url: "/php/admin-save.php",
        type: "POST",
        data: {
            table: "planes",
            id: p_id,
            model: $("#model" + p_id).val(),
            img: $("#img" + p_id).val()
        },
        success: (data) => {
            data = JSON.parse(data);
            if (data.msg == "ok") {
                Notify(`Изменения сохранены!<br> Старые данные: ${data.model} | ${data.img}`);
            } else {
                Notify(data.msg);
            }
        }
    });
}

function SaveUser(u_id) {
    $.ajax({
        url: "/php/admin-save.php",
        type: "POST",
        data: {
            table: "users",
            id: u_id,
            name: $("#name" + u_id).val(),
            login: $("#login" + u_id).val(),
            is_admin: $("#is_admin" + u_id).val()
        },
        success: (data) => {
            data = JSON.parse(data);
            if (data.msg == "ok") {
                Notify(`Изменения сохранены!<br> Старые данные: ${data.type} | ${data.name} | ${data.login}`);
            } else {
                Notify(data.msg);
            }
        }
    });
}

// ----------------delete------------------

function DeleteFlight(f_id) {
    $.ajax({
        url: "/php/admin-del.php",
        type: "POST",
        data: {
            table: "flights",
            id: f_id
        },
        success: (data) => {
            data = JSON.parse(data);
            if (data.msg == "ok") {
                Notify("Рейс удален!");
                $("#tr"+data.id).html(`<td colspan='7'>Рейс удален: ${data.from} | ${data.to} | ${data.dep} | ${data.arr} | ${data.model}</td>`);
            } else {
                Notify(data.msg);
            }
        }
    });
}

function DeletePlane(p_id) {
    $.ajax({
        url: "/php/admin-del.php",
        type: "POST",
        data: {
            table: "planes",
            id: p_id
        },
        success: (data) => {
            data = JSON.parse(data);
            if (data.msg == "ok") {
                Notify("Самолет удален!");
                $("#tr"+data.id).html(`<td colspan='5'>Самолет удален: ${data.model} | ${data.img}</td>`);
            } else {
                Notify(data.msg);
            }
        }
    });
}

function DeleteUser(u_id) {
    $.ajax({
        url: "/php/admin-del.php",
        type: "POST",
        data: {
            table: "users",
            id: u_id
        },
        success: (data) => {
            data = JSON.parse(data);
            if (data.msg == "ok") {
                Notify("Пользователь удален!");
                $("#tr"+data.id).html(`<td colspan='5'>Пользователь удален: ${data.type} | ${data.name} | ${data.login}</td>`);
            } else {
                Notify(data.msg);
            }
        }
    });
}