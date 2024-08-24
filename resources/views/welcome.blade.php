<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App Api</title>
</head>

<body>
    <h1>Welcome to Weather App.</h1>
    <h2> Routes are as follow</h2>

    <table>
        <thead>
            <tr></tr>
            <th>Name</th>
            <th>Path</th>
            <th>Method</th>
            <th>Description</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script>
        const route = [
            {
                "name": "Get Weather",
                "path": "/api/weather",
                "method": "GET",
                "description": "Get Weather"
            },
            {
                "name": "Get Weather",
                "path": "/api/weather/{city}",
                "method": "GET",
                "description": "Get Weather"
            },
            {
                "name": "Get Weather",
                "path": "/api/weather/{city}/{date}",
                "method": "GET",
                "description": "Get Weather"
            }
        ]


        for (let i = 0; i < route.length; i++) {
            document.querySelector("tbody").innerHTML += `
            <tr>
                <td>${route[i].name}</td>
                <td>${route[i].path}</td>
                <td>${route[i].method}</td>
                <td>${route[i].description}</td>
            </tr>
            `
        }
    </script>
</body>

</html>