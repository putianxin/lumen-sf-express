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
/**物流查询**/
$tracking_number = 811089125247;
SF::route()->Routes($tracking_number);

/**下单**/
// 你自己ERP系统里的订单ID。
$orderid = 88888888;
// 收件方信息
$d_company = '罗湖火车站';
$d_contact = '小雷';
$d_tel = '13800000000';
$d_address = '罗湖火车站东区调度室';

// 其它可选参数
$data = array(
    // 寄件方信息
    'j_mobile'=>'13000000000',
    'j_province'=>'广东省',
    'j_city'=>'深圳',
    'j_county'=>'福田区',
    'j_address'=>'罗湖火车站东区调度室',
    
    'express_type'=>'1', // 快件产品类别
    'pay_method'=>'1', // 付款方式
    'parcel_quantity'=>'1', // 包裹数
    'cargo_length'=>'33', // 货物总长
    'cargo_width'=>'33', // 货物总宽
    'cargo_height'=>'33', // 货物总高
    'remark'=>'' // 备注
);

// 货物信息。可以有多个。 name为必填字段。
$Cargo = array(
    array( 'name'=>'LV背包', 'count'=>'3', 'unit'=>'只', 'weight'=>'', 'amount'=>'', 'currency'=>'', 'source_area'=>''),
    array('name'=>'LV手表', 'count'=>'3', 'unit'=>'块', 'weight'=>'', 'amount'=>'', 'currency'=>'', 'source_area'=>'')
);

// 下单
SF::order->Order($orderid , $d_company, $d_contact, $d_tel, $d_address, $data, $Cargo);
```
## License

MIT
