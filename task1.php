<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./assets/css/tailwind.css" rel="stylesheet">
    <title>Прогресс бар с фетч</title>
    <style>
        .loader {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .progress-bar {
            height: 20px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            background-color: #4caf50;
            transition: width 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-100 p-8">

<div class="flex items-center justify-center">
    <button onclick="makeRequestsSequentially()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Имитация запросов
    </button>
</div>

<div id="loader" class="hidden loader"></div>

<div id="progress-bars" class="mt-4">
    <div id="progress-bar-1" class="hidden progress-bar">
        <div id="progress-fill-1" class="progress-fill" style="width: 0;"></div>
    </div>
    <div id="progress-bar-2" class="hidden progress-bar">
        <div id="progress-fill-2" class="progress-fill" style="width: 0;"></div>
    </div>
    <div id="progress-bar-3" class="hidden progress-bar">
        <div id="progress-fill-3" class="progress-fill" style="width: 0;"></div>
    </div>
</div>

<div class="mt-4">
    <button onclick="goToIndex()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        Вернуться на главную
    </button>
</div>

<script>
    function showLoader() {
        document.getElementById('loader').classList.remove('hidden');
    }

    function hideLoader() {
        document.getElementById('loader').classList.add('hidden');
    }

    function showProgressBar(id) {
        const progressBar = document.getElementById(`progress-bar-${id}`);
        if (progressBar) {
            progressBar.classList.remove('hidden');
        }
    }

    function updateProgressBar(id, percentage) {
        const progressFill = document.getElementById(`progress-fill-${id}`);
        if (progressFill) {
            progressFill.style.width = `${percentage}%`;
        }
    }

    async function makeRequest(url, timeout, progressBarId) {
        try {
            showProgressBar(progressBarId);
            showLoader();

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error(`Network response was not ok: ${response.status}`);
            }

            const contentLength = Number(response.headers.get('Content-Length'));
            let receivedLength = 0;

            const reader = response.body.getReader();

            while (true) {
                const { done, value } = await reader.read();

                if (done) {
                    hideLoader();
                    updateProgressBar(progressBarId, 100);
                    break;
                }

                receivedLength += value.length;
                const percentage = (receivedLength / contentLength) * 100;
                updateProgressBar(progressBarId, percentage);
            }
        } catch (error) {
            console.error('Error during fetch:', error);
            hideLoader();
            updateProgressBar(progressBarId, 0);
            throw error;
        }
    }

    async function makeRequestsSequentially() {
        try {
            resetProgressBars();
            await makeRequest('./modules_task1/backend1.php', 5000, 1);
            await makeRequest('./modules_task1/backend2.php', 15000, 2);
            await makeRequest('./modules_task1/backend3.php', 10000, 3);
            allSuccess();
        } catch (error) {
            console.error('Error during requests:', error);
        }
    }

    function resetProgressBars() {
        for (let i = 1; i <= 3; i++) {
            const progressBar = document.getElementById(`progress-bar-${i}`);
            const progressFill = document.getElementById(`progress-fill-${i}`);

            if (progressBar && progressFill) {
                progressBar.classList.add('hidden');
                progressFill.style.width = '0';
            }
        }
    }

    function allSuccess() {
        alert('УРА!');
    }

    function goToIndex() {
        window.location.href = 'index.php';
    }
</script>

</body>
</html>
