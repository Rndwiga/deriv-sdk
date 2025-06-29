<?php

namespace Rndwiga\DerivApis\Api;

/**
 * Handler for Deriv Economic Calendar APIs
 * Provides information about economic events that might impact the markets
 */
class EconomicCalendar extends BaseApi
{
    /**
     * Get economic calendar events
     *
     * @param array $params Filter parameters
     * @return array
     */
    public function getEconomicCalendar(array $params = [])
    {
        return $this->sendRequest(array_merge(
            ['economic_calendar' => 1],
            $params
        ));
    }

    /**
     * Get details of a specific economic event
     *
     * @param string $eventId ID of the economic event
     * @return array
     */
    public function getEconomicEvent($eventId)
    {
        return $this->sendRequest([
            'economic_event' => $eventId
        ]);
    }

    /**
     * Subscribe to economic calendar updates
     *
     * @param array $params Filter parameters
     * @return array
     */
    public function subscribeEconomicCalendar(array $params = [])
    {
        return $this->sendRequest(array_merge(
            ['economic_calendar' => 1, 'subscribe' => 1],
            $params
        ));
    }
}