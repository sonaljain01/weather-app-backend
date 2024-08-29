
# Weather App Backend

A Weather App Backend used to send current weather data, including forecast and weather history and weather alert. WeatherAPI provides weather data, including current, 14-day, future, and historical weather, as well as geo data, time zone information, and astronomy data.

**Note:** Api is live on [this](https://cjxiaojia.com/).

## API Reference

#### Get location Data

```http
  POST /api/location
```

| Parameter         | Type     | Description |
| :-----------------| :------- | :---------  |
| `city`            | `string` | **Optional**|
| `state`           | `string` | **Optional**|
| `country`         | `string` | **Optional**|
| `lat`             | `string` | **Optional**|
| `long`            | `string` | **Optional**|

#### Get weather forecat

```http
  POST /api/forecast
```

| Parameter         | Type     | Description |
| :-----------------| :------- | :---------  |
| `city`            | `string` | **Optional**|
| `state`           | `string` | **Optional**|
| `country`         | `string` | **Optional**|
| `lat`             | `string` | **Optional**|
| `long`            | `string` | **Optional**|

#### Get weather history

```http
  POST /api/history
```

| Parameter         | Type     | Description |
| :-----------------| :------- | :---------  |
| `city`            | `string` | **Optional**|
| `state`           | `string` | **Optional**|
| `country`         | `string` | **Optional**|
| `lat`             | `string` | **Optional**|
| `long`            | `string` | **Optional**|


#### Get Location Suggestion

```http
  POST /api/suggestion
```

| Parameter         | Type     | Description |
| :-----------------| :------- | :---------  |
| `data`            | `string` | **Required min:3 max:255**|


## Run Locally

Clone the project

```bash
  git clone https://github.com/arihant-getgrahak/weather-app-backend
```

Go to the project directory

```bash
  cd weather-app-backend
```

Install Dependencies


```bash
  composer install
```

Migrate data to database


```bash
php artisan migrate
```

Start the server

```bash
  herd open || php artisan serve
```

## Response Schema

[Postman](https://www.postman.com/sonaljain01/workspace/weather-app-backend/request/37798694-41476040-32d3-4961-b41e-1d906ef645b5)
## Tech Stack

**Client:** PHP, Laravel

**Server:** Herd

## Required
PHP version 8.3


## Documentation

[Herd](https://herd.laravel.com/docs/windows/1/getting-started/about-herd)

[Laravel](https://laravel.com/docs/11.x/installation)


## Contribution

1. [@arihant-getgrahak](https://www.github.com/arihant-getgrahak)
2. [@sonaljain01](https://www.github.com/sonaljain01)