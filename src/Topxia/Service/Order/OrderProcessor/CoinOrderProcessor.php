<?php
namespace Topxia\Service\Order\OrderProcessor;

use Topxia\Service\Common\ServiceKernel;

class CoinOrderProcessor extends BaseProcessor implements OrderProcessor
{
    protected $router = "my_coin";

    public function getRouter()
    {
        return $this->router;
    }

    public function preCheck($targetId, $userId)
    {
    }

    public function getOrderInfo($targetId, $fields)
    {
    }

    public function shouldPayAmount($targetId, $priceType, $cashRate, $coinEnabled, $fields)
    {
    }

    public function createOrder($orderInfo, $fields)
    {
    }

    protected function getTotalPrice($targetId, $priceType)
    {
    }

    public function doPaySuccess($success, $order)
    {
    }

    public function getOrderBySn($sn)
    {
        return $this->getCashOrdersService()->getOrderBySn($sn);
    }

    public function getOrderMessage($order)
    {
        $orderInfo             = $this->getCashOrdersService()->getOrder($order['id']);
        $orderInfo['template'] = 'coin';
        return $orderInfo;
    }

    public function updateOrder($id, $fileds)
    {
        return $this->getCashOrdersService()->updateOrder($id, $fileds);
    }

    public function getNote($targetId)
    {
        $coin = $this->getSettingService()->get('coin');
        return '充值'.$coin['coin_name'];
    }

    public function getTitle($targetId)
    {
        $coin = $this->getSettingService()->get('coin');
        return $coin['coin_name'];
    }

    public function pay($payData)
    {
        return $this->getCashOrdersService()->payOrder($payData);
    }

    public function callbackUrl($router, $order, $container)
    {
        $goto = !empty($router) ? $container->get('router')->generate($router) : $this->generateUrl('homepage', array(), true);
        return $goto;
    }

    public function cancelOrder($id, $message, $data)
    {
        return $this->getCashOrdersService()->cancelOrder($id, $message, $data);
    }

    public function createPayRecord($id, $payData)
    {
        return $this->getCashOrdersService()->createPayRecord($id, $payData);
    }

    protected function getCashOrdersService()
    {
        return ServiceKernel::instance()->createService('Cash.CashOrdersService');
    }

    protected function getSettingService()
    {
        return ServiceKernel::instance()->createService('System.SettingService');
    }

}
