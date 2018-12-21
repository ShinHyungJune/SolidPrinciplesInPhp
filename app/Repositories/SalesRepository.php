<?php
/**
 * Created by PhpStorm.
 * User: barocomics
 * Date: 2018-12-21
 * Time: 오전 11:10
 */

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class SalesRepository
{
    public function between($startDate, $endDate)
    {
        return DB::table('sales')->whereBetween('created_at', [$startDate, $endDate])->sum('charge') / 100;
    }
}
