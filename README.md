# KingMonitor

API requests and errors monitor.

## Installation

Use the composer to install the package.

```bash
composer require bycarmona141/king-monitor
```

## Usage

```php
public function kingIndex(): KingCategoryCollection {
    $response = KingCategoryCollection::make(KingCategory::all());

    KingMonitor::monitor($response);

    return $response;
}
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)
