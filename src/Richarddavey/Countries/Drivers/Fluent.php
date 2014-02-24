<?php namespace Richarddavey\Countries\Drivers;

class Fluent implements DriverInterface {

    /**
     * Application instance
     * 
     * @var Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Registry table name
     * 
     * @var string
     */
    protected $table;

	/**
	 * Countries metadata
	 *
     */
	private $ISO3166_1_alpha2;
	private $ISO3166_1_alpha3;
	private $ISO3166_1_num;
	
	/**
	 * All Countries
	 *
     */
	private $countries;
	
    /**
     * Constructor
     * 
     * @param Illuminate\Foundation\Application $app
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->table = $this->app['config']->get('richarddavey/countries::table', 'countries');
    }
	
	/**
	 * Convert input number of country to international dialing using ISO3166_1_alpha2 code
	 *
	 * @param $country of input number
	 * @param $phone
	 * @param $current county for output
	 * @return object
	 */
	public function dialcode($country, $phone, $current = 'GB')
	{
		// ensure data has been loaded
		$this->load();
		
	    // country exists
		if ($phone && isset($this->ISO3166_1_alpha2[$country]) && isset($this->ISO3166_1_alpha2[$current])) {
			
		    // is already safe
		    if ($country == $current) return $phone;
		    
			// remove local code
			if ($this->ISO3166_1_alpha2[$country]->NDD == substr($phone, 0, strlen($this->ISO3166_1_alpha2[$country]->NDD))) {
				
				// set new number
				$phone = substr($phone, strlen($this->ISO3166_1_alpha2[$country]->NDD));
				
				// return number
				return $this->ISO3166_1_alpha2[$country]->IDD . $this->ISO3166_1_alpha2[$country]->IDC . $phone;
			
			// already removed	
			} else if ($this->ISO3166_1_alpha2[$country]->IDC == substr($phone, 0, strlen($this->ISO3166_1_alpha2[$country]->IDC))) {
				
			    // return original number
		        return $phone;
		    }
		}
		
		// return failed
		return null;
	}
	
	/**
	 * Convert number to international dialing using ISO3166_1_alpha2 code
	 *
	 * @param $country
	 * @param $phone
	 * @param $current
	 * @return object
	 */
	public function raw_phone($country, $phone)
	{
		// ensure data has been loaded
		$this->load();
		
	    // country exists
		if ($phone && isset($this->ISO3166_1_alpha2[$country])) {
			
			// remove local code
			if ($this->ISO3166_1_alpha2[$country]->NDD == substr($phone, 0, strlen($this->ISO3166_1_alpha2[$country]->NDD))) {
				
				// set new number
				$phone = substr($phone, strlen($this->ISO3166_1_alpha2[$country]->NDD));
				
				// return number
				return $this->ISO3166_1_alpha2[$country]->IDC . $phone;
			
			// remove idc code
		    } else if ($this->ISO3166_1_alpha2[$country]->IDC == substr($phone, 0, strlen($this->ISO3166_1_alpha2[$country]->IDC))) {
				
				// set new number
				$phone = substr($phone, strlen($this->ISO3166_1_alpha2[$country]->IDC));
				
				// return number
				return $phone;
			}
		}
		
		// return failed
		return null;
	}
	
	/**
	 * Convert number to international dialing using ISO3166_1_alpha2 code
	 *
	 * @param $country
	 * @param $phone
	 * @param $current
	 * @return object
	 */
	public function clean_phone($country, $phone)
	{
		// ensure data has been loaded
		$this->load();
		
	    // country exists
		if ($phone && isset($this->ISO3166_1_alpha2[$country])) {
			
			// remove idc code
			if ($this->ISO3166_1_alpha2[$country]->IDC == substr($phone, 0, strlen($this->ISO3166_1_alpha2[$country]->IDC))) {
				
				// set new number
				$phone = substr($phone, strlen($this->ISO3166_1_alpha2[$country]->IDC));
				
				// return number
				return $this->ISO3166_1_alpha2[$country]->NDD . $phone;
				
			// already removed
			} else if ($this->ISO3166_1_alpha2[$country]->NDD == substr($phone, 0, strlen($this->ISO3166_1_alpha2[$country]->NDD))) {
			    
			    // return original number
		        return $phone;
		        
		    // add missing ndd
			} else {
			    
			    // return number
				return $this->ISO3166_1_alpha2[$country]->NDD . $phone;
			}
		}
		
		// return failed
		return null;
	}
	
	/**
	 * Load countries
	 *
	 * @return object
	 */
	private function load()
	{
		// no data
		if (!$this->countries) {
			
			// get all
			$countries = $this->app['db']->table($this->table)->orderBy('name', 'asc');
			
			// rows found
			if ($countries->count()) {
				foreach ($countries->get() as $key => $country) {
					$this->countries[$country->name] = $country;
					if ($country->ISO3166_1_alpha2) $this->ISO3166_1_alpha2[$country->ISO3166_1_alpha2] = $country;
					if ($country->ISO3166_1_alpha3) $this->ISO3166_1_alpha3[$country->ISO3166_1_alpha3] = $country;
					if ($country->ISO3166_1_num) $this->ISO3166_1_num[$country->ISO3166_1_num] = $country;
				}
			}
		}
		
		// return user data
		return $this->countries;
	}
	
	/**
	 * List countries
	 *
	 * @return object
	 */
	public function list_codes()
	{
		// ensure data has been loaded
		$this->load();
		
	    // return codes
		return $this->ISO3166_1_alpha2 ? $this->ISO3166_1_alpha2 : NULL;
	}
}
