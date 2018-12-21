<?php
/**
 * Created by PhpStorm.
 * User: barocomics
 * Date: 2018-12-21
 * Time: 오전 10:58
 */

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Repositories\SalesRepository;
use App\SalesOutputInterface;

class SalesReporter
{
    private $repo;

    public function __construct(SalesRepository $repository)
    {
        $this->repo = $repository;
    }

    public function between($startDate, $endDate, SalesOutputInterface $formatter)
    {
        // perform authentication
        // if(! Auth::check() ) throw new Exception('Authentication required for reporting');
        // -> 왜 SalesReporter가 authenticate까지 신경써야함? 얘는 Sales를 Report하는 책임만 갖고 있어
        // 컨트롤러같은데서 처리하게 치워버리기

        // get sales from db
        // $sales = $this->queryDbForSalesBetween($startDate, $endDate);
        $sales = $this->repo->between($startDate, $endDate);

        // return results
        // return $this->format($sales);
        $formatter->output($sales);

        /*
         * 결론
         * 이로써 SalesReporter는 더 이상 유저인증, DB기록, 아웃풋 포맷에 대한 책임이 없음.
         * 오로지 report하는 과정에만 신경쓰면됨.
        */

    }

    // 지금 아래 두 메소드만 봐도 가져가는 쿼리특성이 달라지거나, 내보낼 때의 포맷이 달라지는 두 가지 이유에 의해서 코드가 변함
    // Single Reponsivility는 단 한가지의 이유로 변경되야함.
    // 아래 작업들을 알맞은 클래스를 만들어 거기서 처리하게하기.
    protected function queryDBForSalesBetween($startDate, $endDate)
    {
        return DB::table('sales')->whereBetween('created_at', [$startDate, $endDate])->sum('charge') / 100;
    }

    protected function format($sales)
    {
        return "<h1>Sales: $sales</h1>";
    }


}
