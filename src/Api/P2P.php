<?php

namespace Rndwiga\DerivApis\Api;

/**
 * Handler for Deriv P2P APIs
 * @see https://developers.deriv.com/docs/p2p
 */
class P2P extends BaseApi
{
    /**
     * Get P2P advertiser info
     *
     * @param string|null $advertiserId Advertiser ID (optional)
     * @return array
     */
    public function getAdvertiserInfo($advertiserId = null)
    {
        $params = ['p2p_advertiser_info' => 1];
        
        if ($advertiserId) {
            $params['id'] = $advertiserId;
        }
        
        return $this->sendRequest($params);
    }

    /**
     * Create P2P advertiser
     *
     * @param array $params Advertiser parameters
     * @return array
     */
    public function createAdvertiser(array $params)
    {
        return $this->sendRequest(array_merge(
            ['p2p_advertiser_create' => 1],
            $params
        ));
    }

    /**
     * Update P2P advertiser
     *
     * @param array $params Advertiser parameters
     * @return array
     */
    public function updateAdvertiser(array $params)
    {
        return $this->sendRequest(array_merge(
            ['p2p_advertiser_update' => 1],
            $params
        ));
    }

    /**
     * Get P2P advertisements
     *
     * @param array $params Filter parameters
     * @return array
     */
    public function getAdvertisements(array $params = [])
    {
        return $this->sendRequest(array_merge(
            ['p2p_advert_list' => 1],
            $params
        ));
    }

    /**
     * Get P2P advertisement information
     *
     * @param int $advertId Advertisement ID
     * @return array
     */
    public function getAdvertisementInfo($advertId)
    {
        return $this->sendRequest([
            'p2p_advert_info' => 1,
            'id' => $advertId
        ]);
    }

    /**
     * Create P2P advertisement
     *
     * @param array $params Advertisement parameters
     * @return array
     */
    public function createAdvertisement(array $params)
    {
        return $this->sendRequest(array_merge(
            ['p2p_advert_create' => 1],
            $params
        ));
    }

    /**
     * Update P2P advertisement
     *
     * @param int $advertId Advertisement ID
     * @param array $params Advertisement parameters
     * @return array
     */
    public function updateAdvertisement($advertId, array $params)
    {
        return $this->sendRequest(array_merge(
            [
                'p2p_advert_update' => 1,
                'id' => $advertId
            ],
            $params
        ));
    }

    /**
     * Delete P2P advertisement
     *
     * @param int $advertId Advertisement ID
     * @return array
     */
    public function deleteAdvertisement($advertId)
    {
        return $this->sendRequest([
            'p2p_advert_delete' => 1,
            'id' => $advertId
        ]);
    }

    /**
     * Get P2P orders
     *
     * @param array $params Filter parameters
     * @return array
     */
    public function getOrders(array $params = [])
    {
        return $this->sendRequest(array_merge(
            ['p2p_order_list' => 1],
            $params
        ));
    }

    /**
     * Get P2P order information
     *
     * @param int $orderId Order ID
     * @return array
     */
    public function getOrderInfo($orderId)
    {
        return $this->sendRequest([
            'p2p_order_info' => 1,
            'id' => $orderId
        ]);
    }

    /**
     * Create P2P order
     *
     * @param array $params Order parameters
     * @return array
     */
    public function createOrder(array $params)
    {
        return $this->sendRequest(array_merge(
            ['p2p_order_create' => 1],
            $params
        ));
    }

    /**
     * Confirm P2P order payment
     *
     * @param int $orderId Order ID
     * @return array
     */
    public function confirmOrderPayment($orderId)
    {
        return $this->sendRequest([
            'p2p_order_confirm' => 1,
            'id' => $orderId
        ]);
    }

    /**
     * Cancel P2P order
     *
     * @param int $orderId Order ID
     * @return array
     */
    public function cancelOrder($orderId)
    {
        return $this->sendRequest([
            'p2p_order_cancel' => 1,
            'id' => $orderId
        ]);
    }

    /**
     * Get P2P payment methods
     *
     * @return array
     */
    public function getPaymentMethods()
    {
        return $this->sendRequest([
            'p2p_payment_methods' => 1
        ]);
    }

    /**
     * Get P2P chat messages
     *
     * @param int $orderId Order ID
     * @return array
     */
    public function getChatMessages($orderId)
    {
        return $this->sendRequest([
            'p2p_chat_messages' => 1,
            'order_id' => $orderId
        ]);
    }

    /**
     * Send P2P chat message
     *
     * @param int $orderId Order ID
     * @param string $message Message content
     * @return array
     */
    public function sendChatMessage($orderId, $message)
    {
        return $this->sendRequest([
            'p2p_chat_create' => 1,
            'order_id' => $orderId,
            'message' => $message
        ]);
    }
}