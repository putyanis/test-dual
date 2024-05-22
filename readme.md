### 1. Исправьте код на стандарт языка PHP 8.1:

```php
$arParams = [];
if (array_key_exists('all_params', $arParams) && is_array($arParams['all_params']))
{
    echo '<pre>';
    print_r($arParams['all_params']);
    echo '</pre>';
}
```

### 2. Исправьте код на стандарт языка PHP 8.1:

```php
class Settings
{
    public static function getPhone(string $phone): string
    {
        return $phone;
    }
    
    public static function getName(string $name): array
    {
        return [
            'name'  => $name,
            'phone' => Settings::getPhone($name),
        ];
    }
}
```

### 3. Напишите простую функцию рекурсии:

```php
function recursion(int $number): void
{
    echo $number.'<br>';
    $number -= 1;
    
    if ($number > 0)
    {
        recursion($number);
    }
}

recursion(10);
```
