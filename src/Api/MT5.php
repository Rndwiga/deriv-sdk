<?php

namespace Rndwiga\DerivApis\Api;

/**
 * Handler for Deriv MT5 APIs
 * @see https://developers.deriv.com/docs/mt5
 */
class MT5 extends BaseApi
{
    /**
     * Get MT5 account details
     *
     * @param string|null $loginId MT5 login ID (optional)
     * @return array
     */
    public function getAccountDetails($loginId = null)
    {
        $params = ['mt5_login_list' => 1];

        if ($loginId) {
            $params['mt5_login'] = $loginId;
        }

        return $this->sendRequest($params);
    }

    /**
     * Get MT5 account types
     *
     * @return array
     */
    public function getAccountTypes()
    {
        return $this->sendRequest([
            'mt5_get_settings' => 1
        ]);
    }

    /**
     * Create MT5 account
     *
     * @param array $params Account parameters
     * @return array
     */
    public function createAccount(array $params)
    {
        return $this->sendRequest(array_merge(
            ['mt5_new_account' => 1],
            $params
        ));
    }

    /**
     * Deposit to MT5 account
     *
     * @param string $loginId MT5 login ID
     * @param float $amount Amount to deposit
     * @return array
     */
    public function deposit($loginId, $amount)
    {
        return $this->sendRequest([
            'mt5_deposit' => 1,
            'to_mt5' => $loginId,
            'amount' => $amount
        ]);
    }

    /**
     * Withdraw from MT5 account
     *
     * @param string $loginId MT5 login ID
     * @param float $amount Amount to withdraw
     * @return array
     */
    public function withdraw($loginId, $amount)
    {
        return $this->sendRequest([
            'mt5_withdrawal' => 1,
            'from_mt5' => $loginId,
            'amount' => $amount
        ]);
    }

    /**
     * Get MT5 password reset
     *
     * @param string $loginId MT5 login ID
     * @param string $passwordType Password type (main, investor)
     * @return array
     */
    public function passwordReset($loginId, $passwordType)
    {
        return $this->sendRequest([
            'mt5_password_reset' => 1,
            'login' => $loginId,
            'password_type' => $passwordType
        ]);
    }

    /**
     * Change MT5 password
     *
     * @param string $loginId MT5 login ID
     * @param string $passwordType Password type (main, investor)
     * @param string $oldPassword Old password
     * @param string $newPassword New password
     * @return array
     */
    public function passwordChange($loginId, $passwordType, $oldPassword, $newPassword)
    {
        return $this->sendRequest([
            'mt5_password_change' => 1,
            'login' => $loginId,
            'password_type' => $passwordType,
            'old_password' => $oldPassword,
            'new_password' => $newPassword
        ]);
    }

    /**
     * Get MT5 account balance
     *
     * @param string $loginId MT5 login ID
     * @return array
     */
    public function getAccountBalance($loginId)
    {
        return $this->sendRequest([
            'mt5_login_list' => 1,
            'mt5_login' => $loginId
        ]);
    }

    /**
     * Get MT5 deposit/withdrawal history
     *
     * @param array $params Filter parameters
     * @return array
     */
    public function getTransactionHistory(array $params = [])
    {
        return $this->sendRequest(array_merge(
            ['mt5_history' => 1],
            $params
        ));
    }

    /**
     * Set MT5 account settings
     *
     * @param string $loginId MT5 login ID
     * @param array $settings Settings to update
     * @return array
     */
    public function setAccountSettings($loginId, array $settings)
    {
        return $this->sendRequest(array_merge(
            [
                'mt5_set_settings' => 1,
                'login' => $loginId
            ],
            $settings
        ));
    }

    /**
     * Get MT5 trade history
     *
     * @param array $params Filter parameters
     * @return array
     */
    public function getMT5TradeHistory(array $params = [])
    {
        return $this->sendRequest(array_merge(
            ['mt5_trade_history' => 1],
            $params
        ));
    }

    /**
     * Get open positions in MT5
     *
     * @param array $params Filter parameters
     * @return array
     */
    public function getMT5OpenPositions(array $params = [])
    {
        return $this->sendRequest(array_merge(
            ['mt5_open_positions' => 1],
            $params
        ));
    }

    /**
     * Place an order directly in MT5
     *
     * @param array $params Order parameters
     * @return array
     */
    public function placeMT5Order(array $params)
    {
        return $this->sendRequest(array_merge(
            ['mt5_place_order' => 1],
            $params
        ));
    }

    /**
     * Modify an existing MT5 order
     *
     * @param string $orderId MT5 order ID
     * @param array $params Order parameters to modify
     * @return array
     */
    public function modifyMT5Order($orderId, array $params)
    {
        return $this->sendRequest(array_merge(
            [
                'mt5_modify_order' => 1,
                'order_id' => $orderId
            ],
            $params
        ));
    }

    /**
     * Close an MT5 position
     *
     * @param string $positionId MT5 position ID
     * @param array $params Additional parameters
     * @return array
     */
    public function closeMT5Position($positionId, array $params = [])
    {
        return $this->sendRequest(array_merge(
            [
                'mt5_close_position' => 1,
                'position_id' => $positionId
            ],
            $params
        ));
    }
}
