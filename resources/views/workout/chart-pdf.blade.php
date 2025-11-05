<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Progression of {{ $plan }}</title>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
        }

        img {
            width: 90%;
            height: auto;
            margin-top: 40px;
        }
    </style>
</head>
<body>
<h1>{{ $plan }} Progression</h1>
<img src="data:image/png;base64,{{ base64_encode(file_get_contents($imagePath)) }}" alt="chart">
</body>
</html>
