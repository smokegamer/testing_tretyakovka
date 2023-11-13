<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./assets/css/tailwind.css" rel="stylesheet">
    <title>Выберите задание</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
<div class="bg-gray-200 p-8 rounded shadow-md">
    <h1 class="text-2xl mb-4">Выберите задание</h1>
    <div class="grid grid-cols-1 gap-4">
        <button class="bg-blue-500 hover:bg-green-500 text-white font-bold py-2 px-4 rounded" onclick="redirectToTask(1)">
            Задание 1
        </button>
        <button class="bg-blue-500 hover:bg-green-500 text-white font-bold py-2 px-4 rounded" onclick="redirectToTask(2)">
            Задание 2
        </button>
        <button class="bg-blue-500 hover:bg-green-500 text-white font-bold py-2 px-4 rounded" onclick="redirectToTask(3)">
            Задание 3
        </button>
    </div>
</div>

<script>
    function redirectToTask(taskNumber) {

        const taskURLs = {
            1: 'task1.php',
            2: 'task2.php',
            3: 'task3.php'
        };

        const url = taskURLs[taskNumber];
        if (url) {
            window.location.href = url;
        } else {
            console.error('URL для задания не найден');
        }
    }
</script>
</body>
</html>
