<?php

namespace Rndwiga\DerivApis\Api;

/**
 * Handler for Deriv Account APIs
 * @see https://developers.deriv.com/docs/account-apis
 */
class Account extends BaseApi
{
    /**
     * Get account information
     *
     * @return array
     */
    public function getAccountInfo()
    {
        return $this->sendRequest([
            'get_account_status' => 1
        ]);
    }

    /**
     * Get account settings
     *
     * @return array
     */
    public function getSettings()
    {
        return $this->sendRequest([
            'get_settings' => 1
        ]);
    }

    /**
     * Update account settings
     *
     * @param array $settings Settings to update
     * @return array
     */
    public function setSettings(array $settings)
    {
        return $this->sendRequest([
            'set_settings' => 1,
            'request_id' => uniqid(),
            'passthrough' => $settings
        ]);
    }

    /**
     * Get account limits
     *
     * @return array
     */
    public function getLimits()
    {
        return $this->sendRequest([
            'get_limits' => 1
        ]);
    }

    /**
     * Get account balance
     *
     * @param string|null $account Account type (optional)
     * @return array
     */
    public function getBalance($account = null)
    {
        $params = ['balance' => 1];
        
        if ($account) {
            $account_options = ['current','all'];//or account Id
            $params['account'] = $account;
        }
        
        return $this->sendRequest($params);
    }

    /**
     * Get self-exclusion settings
     *
     * @return array
     */
    public function getSelfExclusion()
    {
        return $this->sendRequest([
            'get_self_exclusion' => 1
        ]);
    }

    /**
     * Set self-exclusion settings
     *
     * @param array $params Self-exclusion parameters
     * @return array
     */
    public function setSelfExclusion(array $params)
    {
        return $this->sendRequest(array_merge(
            ['set_self_exclusion' => 1],
            $params
        ));
    }

    /**
     * Authenticate user
     *
     * @param string $token Authentication token
     * @return array
     */
    public function authorize($token)
    {
        return $this->sendRequest([
            'authorize' => $token
        ]);
    }

    /**
     * Logout from the current session
     *
     * @return array
     */
    public function logout()
    {
        return $this->sendRequest([
            'logout' => 1
        ]);
    }
}