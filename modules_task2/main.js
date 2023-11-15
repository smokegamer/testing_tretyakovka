document.addEventListener('DOMContentLoaded', function () {
    // Получение данных при загрузке страницы
    fetchData();

    // Обработчик формы для добавления клиента
    document.getElementById('addClientForm').addEventListener('submit', function (e) {
        e.preventDefault();
        addClient();
    });

    // Обработчик для удаления, редактирования и сохранения клиента
    document.getElementById('clientTableBody').addEventListener('click', function (event) {
        const target = event.target.closest('.edit-client-btn');
        if (target) {
            const clientId = target.dataset.clientId;
            toggleEdit(clientId);
        }

        if (event.target.classList.contains('delete-client-btn')) {
            const clientId = event.target.dataset.clientId;
            deleteClient(clientId);
        } else if (event.target.classList.contains('save-client-btn')) {
            const clientId = event.target.dataset.clientId;
            saveClient(clientId);
        }
    });



function fetchData() {
    fetch('./modules_task2/fetch_clients.php', {
        method: 'GET',
    })
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('clientTableBody');
            tableBody.innerHTML = '';
            data.forEach(client => {
                const row = `<tr>
                                    <td class="border border-gray-300 px-4 py-2">${client.id}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <span class="editable" data-field="last_name">${client.last_name}</span>
                                        <input type="text" name="last_name" class="hidden form-input" data-field="last_name" value="${client.last_name}">
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <span class="editable" data-field="first_name">${client.first_name}</span>
                                        <input type="text" class="hidden form-input" data-field="first_name" value="${client.first_name}">
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <span class="editable" data-field="middle_name">${client.middle_name}</span>
                                        <input type="text" class="hidden form-input" data-field="middle_name" value="${client.middle_name}">
                                    </td>
                                   <td class="border border-gray-300 px-4 py-2">
                                 <button class="bg-blue-500 text-white px-4 py-2 rounded client-btn edit-client-btn" data-client-id="${client.id}">
                                        Edit
                                    </button>
                                    <button class="bg-red-500 text-white px-4 py-2 rounded client-btn save-client-btn" data-client-id="${client.id}" style="display: none;">
                                        Save
                                    </button>

                                    </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                        <button class="bg-red-500 text-white px-4 py-2 rounded delete-client-btn" data-client-id="${client.id}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>`;
                tableBody.innerHTML += row;
            });
        })
        .catch(error => console.error('Error fetching data:', error));
}

function addClient() {
    const form = document.getElementById('addClientForm');
    const formData = new FormData(form);

    fetch('./modules_task2/add_client.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchData(); // Обновление данных после успешного добавления
                form.reset(); // Очистка формы
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error adding client:', error));
}
function deleteClient(clientId) {

    fetch('./modules_task2/delete_client.php?id=' + clientId, {
        method: 'DELETE',
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchData(); // Обновление данных после успешного удаления
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error deleting client:', error));
}

    function toggleEdit(clientId) {
        console.log('Toggle Edit called for clientId:', clientId);

        const button = document.querySelector(`[data-client-id="${clientId}"].edit-client-btn`);
        console.log('Button:', button);

        const row = button.closest('tr');
        console.log('Row:', row);

        const editButtons = row.querySelectorAll('.client-btn');
        console.log('Edit buttons:', editButtons);

        const editButton = row.querySelector('.edit-client-btn');
        const saveButton = row.querySelector('.save-client-btn');

        editButton.style.display = 'none';
        saveButton.style.display = 'block';

        const fields = row.querySelectorAll('.editable, .form-input');
        console.log('Проверка существования элементов', fields);
        fields.forEach(field => {
            if (field.dataset.field) {
                if (field.classList.contains('editable')) {
                    field.classList.remove('editable');
                } else {
                    field.classList.add('editable');
                }
            }
        });

        fields.forEach(field => {
            if (field.classList.contains('editable')) {
                field.style.display = (field.style.display === 'none') ? 'inline' : 'none';
            } else {
                field.style.display = (field.style.display === 'none') ? 'block' : 'none';
            }
        });





        function saveClient(clientId) {
        const row = document.querySelector(`[data-client-id="${clientId}"]`);
        if (!row) {
            console.error('Row not found for clientId:', clientId);
            return;
        }
        console.log(row.querySelector('[data-field="last_name"] input'));
        // Получение данных из полей формы
        const lastName = row.querySelector('[data-field="last_name"] input').value;
        const firstName = row.querySelector('[data-field="first_name"] input').value;
        const middleName = row.querySelector('[data-field="middle_name"] input').value;

        // Создание объекта с данными
        const clientData = {
            last_name: lastName,
            first_name: firstName,
            middle_name: middleName
        };

        // Добавление идентификатора клиента
        clientData.id = clientId;

        // Отправка данных на сервер
        fetch(`./modules_task2/update_client.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(clientData)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Fetch executed');
                if (data.success) {
                    toggleEdit(clientId);
                    fetchData();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error saving client:', error);

                if (error instanceof Error) {
                    console.error('Server response:', 'The response does not contain text content.');
                } else {
                    error.text().then(text => {
                        console.error('Server response:', text);
                    }).catch(textError => {
                        console.error('Error getting response text:', textError);
                    });
                }
            });
    }


});