<?php namespace Richarddavey\Countries\Drivers;

interface DriverInterface {

	/**
	 * Convert number to international dialing using ISO3166_1_alpha2 code
	 *
	 * @param $country
	 * @param $phone
	 * @param $current
	 * @return object
	 */
    public function dialcode($country, $phone, $current = 'GB');

	/**
	 * Convert number to international dialing using ISO3166_1_alpha2 code
	 *
	 * @param $country
	 * @param $phone
	 * @param $current
	 * @return object
	 */
	public function raw_phone($country, $phone);
		
	/**
	 * Convert number to international dialing using ISO3166_1_alpha2 code
	 *
	 * @param $country
	 * @param $phone
	 * @param $current
	 * @return object
	 */
	public function clean_phone($country, $phone);
	
	/**
	 * List countries
	 *
	 * @return object
	 */
	public function list_codes();
	
	/**
	 * Load countries
	 *
	 * @return object
	 */
	private function load();
}
