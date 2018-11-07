<?php namespace Ptx\SF\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AbstractOMS
{
    protected $config = [
        'server' => "http://bsp.sit.sf-express.com:8080/",
        'uri' => 'bsp-wms/OmsCommons',
        'checkword' => 'j8DzkIFgmlomPt0aLuwU',
        'accesscode' => 'BSPdevelop',
        'companycode ' => ''
    ];

    private $SERVICE = array(
        'Ptx\SF\OMS\ItemService'                           => 'ITEM_SERVICE',
        'Ptx\SF\OMS\ItemQueryService'                      => 'ITEM_QUERY_SERVICE',
        'Ptx\SF\OMS\ItemChangePushService'                 => 'ITEM_CHANGE_PUSH_SERVICE',
        'Ptx\SF\OMS\BOMService'                            => 'BOM_SERVICE',
        'Ptx\SF\OMS\VendorService'                         => 'VENDOR_SERVICE',
        'Ptx\SF\OMS\PurchaseOrderService'                  => 'PURCHASE_ORDER_SERVICE',
        'Ptx\SF\OMS\CancelPurchaseOrderService'            => 'CANCEL_PURCHASE_ORDER_SERVICE',
        'Ptx\SF\OMS\PurchaseOrderInboundPushService'       => 'PURCHASE_ORDER_INBOUND_PUSH_SERVICE',
        'Ptx\SF\OMS\PurchaseOrderInboundQueryService'      => 'PURCHASE_ORDER_INBOUND_QUERY_SERVICE',
        'Ptx\SF\OMS\SaleOrderService'                      => 'SALE_ORDER_SERVICE',
        'Ptx\SF\OMS\CancelSaleOrderService'                => 'CANCEL_SALE_ORDER_SERVICE',
        'Ptx\SF\OMS\SaleOrderOutboundDetailPushService'    => 'SALE_ORDER_OUTBOUND_DETAIL_PUSH_SERVICE',
        'Ptx\SF\OMS\SaleOrderOutboundDetailQueryService'   => 'SALE_ORDER_OUTBOUND_DETAIL_QUERY_SERVICE',
        'Ptx\SF\OMS\SaleOrderStatusPushService'            => 'SALE_ORDER_STATUS_PUSH_SERVICE',
        'Ptx\SF\OMS\SaleOrderStatusQueryService'           => 'SALE_ORDER_STATUS_QUERY_SERVICE',
        'Ptx\SF\OMS\AsynSaleOrderService'                  => 'ASYN_SALE_ORDER_SERVICE',
        'Ptx\SF\OMS\AsynSaleOrderConfirmPushService'       => 'ASYN_SALE_ORDER_CONFIRM_PUSH_SERVICE',
        'Ptx\SF\OMS\AsynSaleOrderConfirmQueryService'      => 'ASYN_SALE_ORDER_CONFIRM_QUERY_SERVICE',
        'Ptx\SF\OMS\PartialShipmentService'                => 'PARTIAL_SHIPMENT_SERVICE',
        'Ptx\SF\OMS\AllocationOrderService'                => 'ALLOCATION_ORDER_SERVICE',
        'Ptx\SF\OMS\RTInventoryPushService'                => 'RT_INVENTORY_PUSH_SERVICE',
        'Ptx\SF\OMS\RTInventoryQueryService'               => 'RT_INVENTORY_QUERY_SERVICE',
        'Ptx\SF\OMS\InventoryChangeService'                => 'INVENTORY_CHANGE_SERVICE',
        'Ptx\SF\OMS\InventoryBalanceService'               => 'INVENTORY_BALANCE_SERVICE',
        'Ptx\SF\OMS\InventoryBalancePageQueryService'      => 'INVENTORY_BALANCE_PAGE_QUERY_SERVICE',
        'Ptx\SF\OMS\ReceiptSerialNumberService'            => 'RECEIPT_SERIAL_NUMBER_SERVICE',
        'Ptx\SF\OMS\CycleActionQueryService'               => 'CYCLE_ACTION_QUERY_SERVICE',
        'Ptx\SF\OMS\OrderInvoiceService'                   => 'ORDER_INVOICE_SERVICE',
        'Ptx\SF\OMS\SerialNumberPushService'               => 'SERIAL_NUMBER_PUSH_SERVICE',
        'Ptx\SF\OMS\InventorySNQueryService'               => 'INVENTORY_SN_QUERY_SERVICE',
        'Ptx\SF\OMS\CycleCountRequestQueryService'         => 'CYCLE_COUNT_REQUEST_QUERY_SERVICE',
        'Ptx\SF\OMS\CycleCountRequestPushService'          => 'CYCLE_COUNT_REQUEST_PUSH_SERVICE',
        'Ptx\SF\OMS\WmsSaleOrderWavePushService'           => 'WMS_SALE_ORDER_WAVE_PUSH_SERVICE',
        'Ptx\SF\OMS\InventoryOccupancyPushService'         => 'INVENTORY_OCCUPANCY_PUSH_SERVICE',
    );

    protected $ret = array(
        'head' => "ERR",
        'message' => '系统错误',
        'code' => -1
    );

    public function __construct($params = null)
    {
        if (null != $params) {
            $this->config = array_merge($this->config, $params);
        }
    }

    public function ApiPost($query=array(), $header=array()) {
        try {
            $client =  new Client(['base_uri' => $this->config['server']]);

            $header['charset'] = 'UTF-8';
            $header['Content-Type'] = 'application/x-www-form-urlencoded';

            // 数据需要以form_params提交，不然传过去时会附加多余的数据。导致签名验证失败。
            $response = $client->post(
                $this->config['uri'],
                array(
                    'form_params' => $query,
                    'headers' => $header,
                    'verify' => false
                )
            );
            $body = $response->getBody();
            $contents = $body->getContents();
            return $contents;
        } catch(RequestException $e) {
            if ($e->hasResponse()) {
                return $e->getResponse()->getBody()->getContents();
            } else {
                return $e->getMessage();
            }
        }
    }

    /**
     * get request service name.
     * @param null $class
     * @return mixed
     */
    public function getServiceName($class=null) {
        if(empty($class)){
            return $this->SERVICE[get_called_class()];
        }
        return $this->SERVICE[$class];
    }

    /**
     * build full xml.
     * @param $bodyData
     * @return string
     */
    public function buildXml($bodyData){
        $xml = '<Request service="'.$this->getServiceName(get_called_class()).'" lang="zh-CN">' .
            '<Head>' .
            '<AccessCode>'.$this->config['accesscode'].'</AccessCode>' .
            '<Checkword>'.$this->config['checkword'].'</Checkword>' .
            '</Head>'.
            '<Body>' . $bodyData . '</Body>' .
            '</Request>';
        return $xml;
    }
}