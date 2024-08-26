
# Weather App Backend

A Weather App Backend used to send current weather data, including forecast and weather history and weather alert. WeatherAPI provides weather data, including current, 14-day, future, and historical weather, as well as geo data, time zone information, and astronomy data.

## API Reference

#### Get location Data

```http
  POST /api/location
```

| Parameter         | Type     | Description |
| :-----------------| :------- | :---------  |
| `city`            | `string` | **Required**|
| `state`           | `string` | **Required**|
| `country`         | `string` | **Required**|

#### Get weather forecat

```http
  POST /api/forecast
```

| Parameter         | Type     | Description |
| :-----------------| :------- | :---------  |
| `city`            | `string` | **Required**|
| `state`           | `string` | **Required**|
| `country`         | `string` | **Required**|

#### Get weather history

```http
  POST /api/history
```

| Parameter         | Type     | Description |
| :-----------------| :------- | :---------  |
| `city`            | `string` | **Required**|
| `state`           | `string` | **Required**|
| `country`         | `string` | **Required**|


#### Get weather alert

```http
  POST /api/alert
```

| Parameter         | Type     | Description |
| :-----------------| :------- | :---------  |
| `city`            | `string` | **Required**|
| `state`           | `string` | **Required**|
| `country`         | `string` | **Required**|




## Required
PHP version 8.3, 


## Run Locally

Clone the project

```bash
  git clone https://github.com/arihant-getgrahak/weather-app-backend
```

Go to the project directory

```bash
  cd weather-app-backend
```


Start the server

```bash
  herd open
```

    
## Tech Stack

**Client:** PHP, Laravel

**Server:** Herd


## Documentation

[Herd](https://herd.laravel.com/docs/windows/1/getting-started/about-herd)


## Contribution

1. [@arihant-getgrahak](https://www.github.com/arihant-getgrahak)
2. [@sonaljain01](https://www.github.com/sonaljain01)