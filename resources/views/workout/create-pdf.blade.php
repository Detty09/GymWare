<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>{{ $plan['name'] }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background: #fff;
            color: #000;
            margin: 40px;
        }
        h1 {
            text-align: center;
            font-size: 28px;
            margin-top: 20px;
        }
        p {
            font-size: 20px;
            text-align: center;
            text-decoration: underline;
            margin-top: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .exercise-block {
            margin-top: 30px;
            page-break-inside: avoid;
        }
    </style>
</head>
<body>

<h1>{{ $plan['name'] }}</h1>

@foreach($plan['exercises'] as $exercise)
    <div class="exercise-block">
        <p>{{ ucfirst($exercise['data']['name']) }}</p>
        <table>
            <thead>
            <tr>
                <th>Set</th>
                <th>Weight (kg)</th>
                <th>Reps</th>
            </tr>
            </thead>
            <tbody>
            @for($i = 0; $i < $exercise['sets']; $i++)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
            </tbody>
        </table>
    </div>
@endforeach

</body>
</html>
