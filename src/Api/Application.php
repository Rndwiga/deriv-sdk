<?php

namespace Rndwiga\DerivApis\Api;

/**
 * Handler for Deriv Application APIs
 * @see https://developers.deriv.com/docs/application-apis
 */
class Application extends BaseApi
{
    /**
     * Get application information
     *
     * @param int $appId Application ID
     * @return array
     */
    public function getAppInfo($appId)
    {
        return $this->sendRequest([
            'app_get' => $appId
        ]);
    }

    /**
     * Register a new application
     *
     * @param array $params Application parameters
     * @return array
     */
    public function registerApp(array $params)
    {
        return $this->sendRequest(array_merge(
            ['app_register' => 1],
            $params
        ));
    }

    /**
     * Update an application
     *
     * @param int $appId Application ID
     * @param array $params Application parameters
     * @return array
     */
    public function updateApp($appId, array $params)
    {
        return $this->sendRequest(array_merge(
            ['app_update' => $appId],
            $params
        ));
    }

    /**
     * Delete an application
     *
     * @param int $appId Application ID
     * @return array
     */
    public function deleteApp($appId)
    {
        return $this->sendRequest([
            'app_delete' => $appId
        ]);
    }

    /**
     * List all applications
     *
     * @return array
     */
    public function listApps()
    {
        return $this->sendRequest([
            'app_list' => 1
        ]);
    }

    /**
     * Markup an application
     *
     * @param int $appId Application ID
     * @param array $params Markup parameters
     * @return array
     */
    public function markupApp($appId, array $params)
    {
        return $this->sendRequest(array_merge(
            ['app_markup_details' => $appId],
            $params
        ));
    }

    /**
     * Get application markup details
     *
     * @param int $appId Application ID
     * @return array
     */
    public function getAppMarkupDetails($appId)
    {
        return $this->sendRequest([
            'app_markup_details' => $appId
        ]);
    }

    /**
     * Get API token scopes
     *
     * @return array
     */
    public function getApiTokenScopes()
    {
        return $this->sendRequest([
            'api_token' => 1
        ]);
    }

    /**
     * Create API token
     *
     * @param array $params Token parameters
     * @return array
     */
    public function createApiToken(array $params)
    {
        return $this->sendRequest(array_merge(
            ['api_token' => 1, 'new_token' => 1],
            $params
        ));
    }

    /**
     * Delete API token
     *
     * @param string $token Token to delete
     * @return array
     */
    public function deleteApiToken($token)
    {
        return $this->sendRequest([
            'api_token' => 1,
            'delete_token' => $token
        ]);
    }

    /**
     * Get OAuth applications
     *
     * @return array
     */
    public function getOAuthApps()
    {
        return $this->sendRequest([
            'oauth_apps' => 1
        ]);
    }

    /**
     * Revoke OAuth application
     *
     * @param int $appId Application ID
     * @return array
     */
    public function revokeOAuthApp($appId)
    {
        return $this->sendRequest([
            'revoke_oauth_app' => $appId
        ]);
    }

    /**
     * Get copy trading accounts
     *
     * @return array
     */
    public function getCopyTradingAccounts()
    {
        return $this->sendRequest([
            'copy_trading_list' => 1
        ]);
    }

    /**
     * Start copy trading
     *
     * @param array $params Copy trading parameters
     * @return array
     */
    public function startCopyTrading(array $params)
    {
        return $this->sendRequest(array_merge(
            ['copy_start' => 1],
            $params
        ));
    }

    /**
     * Stop copy trading
     *
     * @param array $params Copy trading parameters
     * @return array
     */
    public function stopCopyTrading(array $params)
    {
        return $this->sendRequest(array_merge(
            ['copy_stop' => 1],
            $params
        ));
    }
}