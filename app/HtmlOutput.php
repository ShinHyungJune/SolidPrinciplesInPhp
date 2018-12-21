<?php
/**
 * Created by PhpStorm.
 * User: barocomics
 * Date: 2018-12-21
 * Time: 오전 11:16
 */

namespace App;
use App\SalesOutputInterface;

class HtmlOutput implements SalesOutputInterface
{
    public function output($sales)
    {
        return "<h1>Sales: $sales</h1>";
    }

}
