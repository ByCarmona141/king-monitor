# KingMonitor

Monitoring API Requests and Errors for Laravel.

## Installation

You can install the package via composer:

```bash
composer require bycarmona141/king-monitor
```

## Public Config

You can publish the config file with:

```bash
php artisan vendor:publish king-monitor-config
```

## Variables Config
> [!NOTE]
> The variable values shown are the tool's default values.

The **USER_ERRORS_LIMIT** configuration variable sets the error limit for sending an alert.

```bash
USER_ERRORS_LIMIT=3
```

The **USER_REQUEST_LIMIT** configuration variable sets the request limit for sending an alert.

```bash
USER_REQUEST_LIMIT=1000
```

The **TOKEN_ERRORS_LIMIT** configuration variable sets the error limit for a TOKEN to send an alert.

```bash
TOKEN_ERRORS_LIMIT=3
```

The **TOKEN_REQUEST_LIMIT** configuration variable sets the limit of requests for a TOKEN to send an alert.

```bash
TOKEN_REQUEST_LIMIT=1000
```

The **MONITOR_ALERT** configuration variable enables the monitor to send alerts.

```bash
MONITOR_ALERT=true
```

The **USER_BETWEEN_ALERT** configuration variable configures the time between user alerts.

```bash
USER_BETWEEN_ALERT=3600
```

The **USE_RESOURCE** configuration variable configures whether the application uses RESOURCES

```bash
USE_RESOURCE=false
```

## Usage with collection
```php
public function kingIndex(): KingCategoryCollection {
    $response = KingCategoryCollection::make(KingCategory::all());

    KingMonitor::monitor($response);

    return $response;
}
```

## Use without collection
```php
public function kingIndex(): Response {
    $response = response(Category::all(), 200);

    KingMonitor::monitor($response);

    return $response;
}
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](./LICENSE.md)