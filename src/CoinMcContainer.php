<?php

namespace Anik\CoinMc;

use GuzzleHttp\Client;

/**
* Laravel container for CoinMarketCap API
*/
class CoinMcContainer
{
	/**
	 * @var  string
	 */
	const API_URL = 'https://api.coinmarketcap.com/v1/';

	/**
	 * Make GET Api call to coinmarketcap.com
	 * @param  string $endpoint Endpoint of Api request
	 * @param  array  $params   Array of Get http parameters
	 * @return json           	Return Json object
	 */
	private static function makeRequest ($endpoint, $params = array())
	{
		$client = new Client();

		$url = self::API_URL . $endpoint;

		if ($params) {
			$query = '?' . http_build_query($params);
			$url .= $query;
		}

		$request = $client->request('GET', $url);
		$response = $request->getBody();
		$json = json_decode($response->getContents());
		return $json;
	}

	/**
	 * Get CoinMarketCap tickers sorting by 24h volume
	 * @param  string $limit    	Only returns the top limit results
	 * @param  string $currency 	Currency for convert (default - USD)
	 * @return json            		All ticker object
	 */
	public static function ticker ($limit = false, $currency = false, $start = false)
	{
		$params = array();

		if ($currency) {
			$params['convert'] = $currency;
		}
		if ($limit) {
			$params['limit'] = $limit;
		}
		if ($start) {
			$params['start'] = $start;
		}

		return self::makeRequest('ticker', $params);
	}

	/**
	 * Get ticker for specific coin
	 * @param  string $coin     	Coin name
	 * @param  string $currency 	Currency for convert (default - USD)
	 * @return json           		Specific ticker object
	 */
	public static function tickerCoin ($coin, $currency = false)
	{
		$params = array();

		if ($currency) {
			$params['convert'] = $currency;
		}

		return self::makeRequest('ticker/' . $coin, $params)[0];
	}

	/**
	 * Get global data
	 * @param  string $currency 	Currency for convert (default - USD)
	 * @return json              	Global data object
	 */
	public static function globalData ($currency = false)
	{
		$params = array();

		if ($currency) {
			$params['convert'] = $currency;
		}

		return self::makeRequest('global', $params);
	}
}