<?php

class View_Wedding_Home extends View_Wedding {

    public $your_name;
    public $total_guests;
    public $phone_numer;

    protected $_places = array(
            array(
                'name' => 'Naniboujou Lodge',
                'comment' => 'Half way between Grand Marais and Hovland, a beautiful, quiet spot by the lake.',
                'website' => 'http://www.naniboujou.com/',
                'address' => '20 Naniboujou Trail, Grand Marais, MN 55604',
                'telephone' => '218 387-2688',
            ),
            array(
                'name' => 'Easy Bay Suites',
                'comment' => 'Downtown suites on the beach, next door to guided kayaking and the food co-op.',
                'website' => 'http://www.eastbaysuites.com/',
                'address' => '21 Wisconsin Street, Grand Marais, MN 55604',
                'telephone' => '800 414-2807',
            ),
            array(
                'name' => 'Gunflint Motel & Cabins',
                'comment' => 'Small inn with suites very suitable for a family.',
                'website' => 'http://www.gunflintmotel.com/',
                'address' => '101 5th Ave W, Grand Marais, MN 55604',
                'telephone' => '218 387-1454',
            ),
        );
    
    public function lodgings()
    {
        $lodgings = array();

        foreach ($this->_places as $place)
        {
            $place['map'] = http_build_query(array('q' => $place['address']));
            $lodgings[] = $place;
        }

        return $lodgings;
    }

}
