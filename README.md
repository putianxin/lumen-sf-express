# lumen-sf-express

<p>:calling: 互亿无线 composer package.</p>

## Requirement

- PHP >= 7.1

## 安装

```shell
$ composer require ptx/lumen-sf-express"
```

## 配置

**请移动并修改config中的文件**

```PHP
'checkWord'=>'',//校验码
'clientCode'=>''//顾客编码
```
**请在app.php中注册服务**
```PHP
$app->register(\Ptx\SF\SFServiceProvider::class);
```

## Usage

```php
//物流查询
$tracking_number = 811089125247;
SF::route()->Routes($tracking_number);
```
## License

MIT
