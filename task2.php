<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./assets/css/tailwind.css" rel="stylesheet">
    <title>Clients Table</title>
    <style>
        .editable {
            border-bottom: 2px solid red; /* Или другой цвет подсветки, который вы предпочитаете */
        }
    </style>
</head>
<body class="bg-gray-100 p-6">
<a href="index.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
    Вернуться на главную
</a>
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Clients Table</h1>


    <table class="w-full bg-white border border-gray-300">
        <thead>
        <tr>
            <th class="border border-gray-300 px-4 py-2">ID</th>
            <th class="border border-gray-300 px-4 py-2">Last Name</th>
            <th class="border border-gray-300 px-4 py-2">First Name</th>
            <th class="border border-gray-300 px-4 py-2">Middle Name</th>
            <th class="border border-gray-300 px-4 py-2">Actions</th>

        </tr>
        </thead>
        <tbody id="clientTableBody"></tbody>
    </table>



    <div class="mt-4">
        <h2 class="text-xl font-bold mb-2">Add New Client</h2>

        <form id="addClientForm">
            <input type="text" name="lastName" placeholder="Last Name" class="border rounded px-4 py-2 mr-2">
            <input type="text" name="firstName" placeholder="First Name" class="border rounded px-4 py-2 mr-2">
            <input type="text" name="middleName" placeholder="Middle Name" class="border rounded px-4 py-2 mr-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Client</button>
        </form>


    </div>
</div>

<script src="./modules_task2/main.js"></script>
</body>
</html>
