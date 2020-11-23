<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Main;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function show(){

        /*$masiv = DB::table('mains')
            ->join('garantiy','mains.garantiy_id','=','garantiy.id')
            ->join('vid_garantiy','mains.vid_garantii','=','vid_garantiy.id')
            ->join('ustranenie','mains.ustranenie_id','=','ustranenie.id')
            ->join('vina','mains.vina_id','=','vina.id')
            ->join('status','mains.status','=','status.id')
            ->whereBetween('data',['2020-01-01','2020-12-31'])
            ->select('mains.*','garantiy.name as name_garantiy','vid_garantiy.name as name_vid_gara',
                'ustranenie.name as name_ustranen','vina.name as name_vina','status.name as name_status')
            ->orderBy('id','asc')
            ->where('flag','=', null)
            ->where('deleted_at','=', '0')
            ->get();*/

        /*$masiv = Main::whereBetween('data',['2020-01-01','2020-12-31'])
                ->where('flag','=', null)
                ->where('deleted_at','=', '0')
                ->select(DB::raw('SUM(mains.zatraty) AS summa'))
            ->get();*/

        //dump($masiv);
        /*return view('welcome',['masiv' => $masiv]);*/
        return view('welcome');
    }
}
