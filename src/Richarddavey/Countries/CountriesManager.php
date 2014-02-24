<?php namespace Richarddavey\Countries;

use Illuminate\Support\Manager;

class CountriesManager extends Manager {

    /**
     * Create an instance of Fluent driver
     * 
     * @return Richarddavey\Countries\Drivers\Fluent
     */
    protected function createFluentDriver()
    {
        return new Drivers\Fluent($this->app);
    }

    /**
     * Get registry default driver
     * 
     * @return string
     */
    protected function getDefaultDriver()
    {
        return $this->app['config']->get('richarddavey/countries::default');
    }

}
