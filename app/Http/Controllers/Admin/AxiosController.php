<?php

namespace App\Http\Controllers\Admin;

use App\Download;
use App\Garantiy;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditOrNewGarantiyRequest;
use App\Main;
use App\Purpose;
use App\Status;
use App\Ustranenie;
use App\Vidgarantiy;
use App\Vina;
use App\WorkingStatus;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Array_;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use function foo\func;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use function GuzzleHttp\Psr7\str;

class AxiosController extends Controller
{
    public function save(Main $main, Request $request)
    {

        $nam = $request->name;
        unset($nam['name_garantiy']);
        unset($nam['name_vid_gara']);
        unset($nam['name_vina']);
        unset($nam['name_ustranen']);
        unset($nam['name_status']);
        unset($nam['short_zakazchik']);//short_months
        unset($nam['short_months']);
        unset($nam['short_zakazchik2']);
        unset($nam['name2_flag']);
        unset($nam['name_flag']);

        Main::where('id','=',$nam['id'])
            ->update($nam);
        dump($nam);
        //return $nam;
    }
    public function newSave(Main $main, Request $request)
    {
        $nam = $request->name;
        unset($nam['name_garantiy']);
        unset($nam['name_vid_gara']);
        unset($nam['name_vina']);
        unset($nam['name_ustranen']);
        unset($nam['name_status']);
        /*unset($nam['short_zakazchik']);
        unset($nam['short_months']);
        unset($nam['short_zakazchik2']);
        unset($nam['name2_flag']);
        unset($nam['name_flag']);*/
        //dump($nam);
        if (gettype($nam['months']) == 'array')
        {
            $nam['months']=json_encode($nam['months']);
        }
        //dump($nam);
        $new = Main::create($nam);
        return $new->id;
    }

    public function garantiy(Garantiy $garantiy, Request $request){
        $status = $request->status;
        if ($status == 'all')
        {
            return Garantiy::withTrashed()->get();
        }
        else
        { // если trimmed
            return Garantiy::all();
        }
    }
    public function garantiyEditOrNew(Garantiy $garantiy, EditOrNewGarantiyRequest $request){
        //dump($garantiy);
        $garan = $request->item;
        if ($garan['id']!='')
        {//обновление
            $gar = Garantiy::find($garan['id']);
            $gar->update($garan);
            return Garantiy::withTrashed()->get();
        }
        else
        {//новая запись
            $gar = Garantiy::create($garan);
            return Garantiy::withTrashed()->get();
        }
    }
    public function garantiyDelete(Garantiy $garantiy, Request $request){
        //dump($garantiy);
        $item = $request->item;
        //dump($item);
        if ($item['deleted_at'] == null)
        {//удаление
            $del = Garantiy::find($item['id']);
            $del->deleted_at = date('Y-m-d');
            $del->save();
            return Garantiy::withTrashed()->get();
        }
        else
        {//востановление
            $del = Garantiy::withTrashed()->find($item['id']);
            $del->deleted_at = null;
            $del->save();
            return Garantiy::withTrashed()->get();
        }

    }

    public function vidgarantiy(Garantiy $garantiy, Request $request){
        $status = $request->status;
        if ($status == 'all')
        {
            return Vidgarantiy::withTrashed()->get();
        }
        else
        { // если trimmed
            return Vidgarantiy::all();
        }
    }
    public function vidgarantiyEditOrNew(Vidgarantiy $vidgarantiy, Request $request){
        //dump($garantiy);
        $item = $request->item;
        if ($item['id']!='')
        {//обновление
            $gar = Vidgarantiy::find($item['id']);
            $gar->update($item);
            return Vidgarantiy::withTrashed()->get();
        }
        else
        {//новая запись
            $gar = Vidgarantiy::create($item);
            return Vidgarantiy::withTrashed()->get();
        }

    }
    public function vidgarantiyDelete(Vidgarantiy $vidgarantiy, Request $request){
        //dump($garantiy);
        $item = $request->item;
        //dump($item);
        if ($item['deleted_at'] == null)
        {//удаление
            $del = Vidgarantiy::find($item['id']);
            $del->deleted_at = date('Y-m-d');
            $del->save();
            return Vidgarantiy::withTrashed()->get();
        }
        else
        {//востановление
            $del = Vidgarantiy::withTrashed()->find($item['id']);
            $del->deleted_at = null;
            $del->save();
            return Vidgarantiy::withTrashed()->get();
        }

    }

    public function status(Status $status, Request $request){
        $status = $request->status;
        if ($status == 'all')
        {
            return Status::withTrashed()->get();
        }
        else
        { // если trimmed
            return Status::all();
        }
    }
    public function statusEditOrNew(Status $status, Request $request){
        //dump($garantiy);
        $item = $request->item;
        if ($item['id']!='')
        {//обновление
            $gar = Status::find($item['id']);
            $gar->update($item);
            return Status::withTrashed()->get();
        }
        else
        {//новая запись
            $gar = Status::create($item);
            return Status::withTrashed()->get();
        }

    }
    public function statusDelete(Status $status, Request $request){
        //dump($garantiy);
        $item = $request->item;
        //dump($item);
        if ($item['deleted_at'] == null)
        {//удаление
            $del = Status::find($item['id']);
            $del->deleted_at = date('Y-m-d');
            $del->save();
            return Status::withTrashed()->get();
        }
        else
        {//востановление
            $del = Status::withTrashed()->find($item['id']);
            $del->deleted_at = null;
            $del->save();
            return Status::withTrashed()->get();
        }

    }

    public function vina(Vina $vina, Request $request){
        $status = $request->status;
        if ($status == 'all')
        {
            return Vina::withTrashed()->get();
        }
        else
        { // если trimmed
            return Vina::all();
        }
    }
    public function vinaEditOrNew(Vina $vina,Request $request){
        //dump($garantiy);
        $item = $request->item;
        if ($item['id']!='')
        {//обновление
            $gar = Vina::find($item['id']);
            $gar->update($item);
            return Vina::withTrashed()->get();
        }
        else
        {//новая запись
            $gar = Vina::create($item);
            return Vina::withTrashed()->get();
        }

    }
    public function vinaDelete(Vina $vina, Request $request){
        //dump($garantiy);
        $item = $request->item;
        //dump($item);
        if ($item['deleted_at'] == null)
        {//удаление
            $del = Vina::find($item['id']);
            $del->deleted_at = date('Y-m-d');
            $del->save();
            return Vina::withTrashed()->get();
        }
        else
        {//востановление
            $del = Vina::withTrashed()->find($item['id']);
            $del->deleted_at = null;
            $del->save();
            return Vina::withTrashed()->get();
        }

    }

    public function ustran(Ustranenie $ustranenie, Request $request){
        $status = $request->status;
        if ($status == 'all')
        {
            return Ustranenie::withTrashed()->get();
        }
        else
        { // если trimmed
            return Ustranenie::all();
        }
    }
    public function ustranEditOrNew(Ustranenie $ustranenie, Request $request){
        //dump($garantiy);
        $item = $request->item;
        if ($item['id']!='')
        {//обновление
            $gar = Ustranenie::find($item['id']);
            $gar->update($item);
            return Ustranenie::withTrashed()->get();
        }
        else
        {//новая запись
            $gar = Ustranenie::create($item);
            return Ustranenie::withTrashed()->get();
        }

    }
    public function ustranDelete(Ustranenie $ustranenie, Request $request){
        //dump($garantiy);
        $item = $request->item;
        //dump($item);
        if ($item['deleted_at'] == null)
        {//удаление
            $del = Ustranenie::find($item['id']);
            $del->deleted_at = date('Y-m-d');
            $del->save();
            return Ustranenie::withTrashed()->get();
        }
        else
        {//востановление
            $del = Ustranenie::withTrashed()->find($item['id']);
            $del->deleted_at = null;
            $del->save();
            return Ustranenie::withTrashed()->get();
        }

    }

    public function workStatus(WorkingStatus $workingStatus, Request $request){
        $status = $request->status;
        if ($status == 'all')
        {
            return WorkingStatus::withTrashed()->get();
        }
        else
        { // если trimmed
            return WorkingStatus::all();
        }
    }
    public function workStatusEditOrNew(WorkingStatus $workingStatus, Request $request){
        //dump($garantiy);
        $item = $request->item;
        if ($item['id']!='')
        {//обновление
            $gar = WorkingStatus::find($item['id']);
            $gar->update($item);
            return WorkingStatus::withTrashed()->get();
        }
        else
        {//новая запись
            $gar = WorkingStatus::create($item);
            return WorkingStatus::withTrashed()->get();
        }

    }
    public function workStatusDelete(WorkingStatus $workingStatus, Request $request){
        //dump($garantiy);
        $item = $request->item;
        //dump($item);
        if ($item['deleted_at'] == null)
        {//удаление
            $del = WorkingStatus::find($item['id']);
            $del->deleted_at = date('Y-m-d');
            $del->save();
            return WorkingStatus::withTrashed()->get();
        }
        else
        {//востановление
            $del = WorkingStatus::withTrashed()->find($item['id']);
            $del->deleted_at = null;
            $del->save();
            return WorkingStatus::withTrashed()->get();
        }

    }

    public function purpose(Purpose $purpose, Request $request){
        $status = $request->status;
        if ($status == 'all')
        {
            return Purpose::withTrashed()->get();
        }
        else
        { // если trimmed
            return Purpose::all();
        }
    }
    public function purposeEditOrNew(Purpose $purpose, Request $request){
        //dump($garantiy);
        $item = $request->item;
        if ($item['id']!='')
        {//обновление
            $gar = Purpose::find($item['id']);
            $gar->update($item);
            return Purpose::withTrashed()->get();
        }
        else
        {//новая запись
            $gar = WorkingStatus::create($item);
            return WorkingStatus::withTrashed()->get();
        }

    }
    public function purposeDelete(Purpose $purpose, Request $request){
        //dump($garantiy);
        $item = $request->item;
        //dump($item);
        if ($item['deleted_at'] == null)
        {//удаление
            $del = Purpose::find($item['id']);
            $del->deleted_at = date('Y-m-d');
            $del->save();
            return Purpose::withTrashed()->get();
        }
        else
        {//востановление
            $del = Purpose::withTrashed()->find($item['id']);
            $del->deleted_at = null;
            $del->save();
            return Purpose::withTrashed()->get();
        }

    }

    public function upsavefiles(Request $request)
    {
        /*$nam = $_FILES['files'];
        $dir = __DIR__;
        $filee = __FILE__;
        //корневая папка
        $papka = $_SERVER['DOCUMENT_ROOT'];
        $id = $_POST['my_file_id'];*/
        $papka = $_SERVER['DOCUMENT_ROOT'];
        if( isset($_FILES) ){
            $id='';
            if (isset($_POST['my_file_id']))
            {
                $id = stripslashes($_POST['my_file_id']);
                if ($id == '') { unset($id);}
            }

            // ВАЖНО! тут должны быть все проверки безопасности передавемых файлов и вывести ошибки если нужно
            $uploaddir = './file'; // . - текущая папка где находится submit.php
            // cоздадим папку если её нет
            if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );
            $filess = $_FILES; // полученные файлы

            $done_files = array();
            // переместим файлы из временной директории в указанную
            foreach( $filess as $file ){
                $file_name = $id.$file['name'];
                if( move_uploaded_file( $file['tmp_name'], "$uploaddir/$file_name" ) ){
                    $done_files[] = realpath( "$uploaddir/$file_name" );
                }
                $download = new Download;
                $download->mains_id = $id;
                $download->title = $file['name'];
                $download->path = $papka.'/file/'.$file_name;
                $download->mime = $file['type'];
                $download->size = $file['size'];
                $download->save();
                //dump($file);
            }
            $data = $done_files ? array('files' => $done_files ) : array('error' => 'Ошибка загрузки файлов.');
            die( json_encode( $data ) );
        }
        return;

    }

    public function uploadfiles(Request $request)
    {
        $id = $request->id;
        /*$nam = $_FILES['file'];
        $dir = __DIR__;
        $file = __FILE__;
        //корневая папка
        $papka = $_SERVER['DOCUMENT_ROOT'];
        $id = $_POST['my_file_id'];*/
        $download = Download::where('mains_id',$id)
            ->get();

        return $download;
    }

    public function readFile(Request $request)
    {
        $id = $request->name;
        $put = $_SERVER['DOCUMENT_ROOT'];
        $f = Download::findOrFail($id);
        $filename = $f->path;//$put.'/file/'.$f->mains_id.$f->title;
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header('Content-Type: '.$f->mime);
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($filename));
        header("Accept-Ranges: bytes");
        //readfile($filename);
        //file_get_contents($filename);
        //return;
        return response()->download($filename);
    }

    public function deleteFile(Request $request)
    {
        $id = $request->id;
        $f = Download::findOrFail($id);
        unlink($f->path);
        Download::destroy($id);
        return;
    }

    /*public function changeYear(Request $request)
    {
        $god = $request->god;
        $stat = $request->stat;
        $masiv = Main::whereBetween('data',[$god.'-01-01',$god.'-12-31'])
            ->join('garantiy','mains.garantiy_id','=','garantiy.id')
            ->join('vid_garantiy','mains.vid_garantii','=','vid_garantiy.id')
            ->join('ustranenie','mains.ustranenie_id','=','ustranenie.id')
            ->join('vina','mains.vina_id','=','vina.id')
            ->join('status','mains.status','=','status.id')
            ->select('mains.*','garantiy.name as name_garantiy','vid_garantiy.name as name_vid_gara',
                'ustranenie.name as name_ustranen','vina.name as name_vina','status.name as name_status')
            ->whereNull('flag')
            ->where('deleted_at','=', '0')
            ->orderBy('data','asc')
            ->get();
        return $masiv;
    }*/
    public function statusChangeCard(Request $request)
    {
        $stat = $request->stat;
        $id = $request->id;
        $date = date('Y-m-d');
        /*dump($stat);
        dump($id); exit();*/
        if ($stat=='В работе')
        {
            $flag = Main::withTrashed()->find($id);
            $flag->data_end = null;
            $flag->flag = 1;
            $flag->deleted_at = null;
            $flag->save();
        }
        if ($stat=='Завершенные')
        {
            $flag = Main::withTrashed()->find($id);
            $flag->data_end = $date;
            $flag->flag = 2;
            $flag->deleted_at = null;
            $flag->save();
        }
        if ($stat=='Удаленные')
        {
            $del = Main::withTrashed()->find($id);
            $del->data_end = $date;
            $del->flag = null;
            $del->deleted_at = $date;
            $del->save();
        }
    }
    public function statusChange(Request $request)
    {
        $months = $request->months;
        $stat = $request->stat;
        $god = $request->god;
        $start = '';
        $end = '';
        /*dump($months);
        dump($stat);
        dump($god); exit();*/

        if (count($months) != 0)
        {
            $start = $god . '-' . $months[0] . '-01';
            $end = $god . '-' . $months[count($months) - 1] . '-31';
        }
        else
        {
            $start = $god . '-' . '01' . '-01';
            $end = $god . '-' . '12' . '-31';
        }
        if ($stat=='В работе')
        {
            $masiv = Main::whereBetween('data',[$start,$end])
                ->join('garantiy','mains.garantiy_id','=','garantiy.id')
                ->join('vid_garantiy','mains.vid_garantii','=','vid_garantiy.id')
                ->join('ustranenie','mains.ustranenie_id','=','ustranenie.id')
                ->join('vina','mains.vina_id','=','vina.id')
                ->join('status','mains.status','=','status.id')
                ->join('working_statuses','mains.flag','=','working_statuses.id')
                ->select('mains.*','garantiy.name as name_garantiy','vid_garantiy.name as name_vid_gara',
                    'ustranenie.name as name_ustranen','vina.name as name_vina','status.name as name_status',
                    'working_statuses.name as name_flag','working_statuses.name2 as name2_flag')
                ->orderBy('data','asc')
                ->where('flag','=',1)
                //->where('mains.deleted_at','=', '0')
                ->get();
        }
        if ($stat=='Завершенные')
        {
            $masiv = Main::whereBetween('data',[$start,$end])
                ->join('garantiy','mains.garantiy_id','=','garantiy.id')
                ->join('vid_garantiy','mains.vid_garantii','=','vid_garantiy.id')
                ->join('ustranenie','mains.ustranenie_id','=','ustranenie.id')
                ->join('vina','mains.vina_id','=','vina.id')
                ->join('status','mains.status','=','status.id')
                ->join('working_statuses','mains.flag','=','working_statuses.id')
                ->select('mains.*','garantiy.name as name_garantiy','vid_garantiy.name as name_vid_gara',
                    'ustranenie.name as name_ustranen','vina.name as name_vina','status.name as name_status',
                    'working_statuses.name as name_flag','working_statuses.name2 as name2_flag')
                ->orderBy('data','asc')
                ->where('flag','=',2)
                //->where('mains.deleted_at','=', '0')
                ->get();
        }
        if ($stat=='Удаленные')
        {
            $masiv = Main::onlyTrashed()->whereBetween('data',[$start,$end])
                ->join('garantiy','mains.garantiy_id','=','garantiy.id')
                ->join('vid_garantiy','mains.vid_garantii','=','vid_garantiy.id')
                ->join('ustranenie','mains.ustranenie_id','=','ustranenie.id')
                ->join('vina','mains.vina_id','=','vina.id')
                ->join('status','mains.status','=','status.id')
                ->select('mains.*','garantiy.name as name_garantiy','vid_garantiy.name as name_vid_gara',
                    'ustranenie.name as name_ustranen','vina.name as name_vina','status.name as name_status')
                ->orderBy('data','asc')
                ->get();
        }
        return $masiv;
    }

    public function inExcel(Request $request)
    {
        $stat = $request->stat;
        $god = $request->god;
        $head = $request->head;
        $masi = $request->masiv;

        /*dump($stat);
        dump($god);
        dump($head); exit();*/

        $put = $_SERVER['DOCUMENT_ROOT'];
        if ($masi == '')
        {
            if ($stat==='В работе')
            {
                $masiv = DB::table('mains')
                    ->join('garantiy','mains.garantiy_id','=','garantiy.id')
                    ->join('vid_garantiy','mains.vid_garantii','=','vid_garantiy.id')
                    ->join('ustranenie','mains.ustranenie_id','=','ustranenie.id')
                    ->join('vina','mains.vina_id','=','vina.id')
                    ->join('status','mains.status','=','status.id')
                    ->join('working_statuses','mains.flag','=','working_statuses.id')
                    ->whereBetween('data',[$god.'-01-01',$god.'-12-31'])
                    ->select('mains.*','vid_garantiy.name as name_vid_gara',
                        'ustranenie.name as name_ustranen','vina.name as name_vina','status.name as name_status',
                        'garantiy.name as name_garantiy','working_statuses.name as name_flag','working_statuses.name2 as name2_flag')
                    ->where('flag','=',1)
                    ->orderBy('id','asc')
                    ->get();
            }
            if ($stat==='Завершенные')
            {
                $masiv = DB::table('mains')
                    ->join('garantiy','mains.garantiy_id','=','garantiy.id')
                    ->join('vid_garantiy','mains.vid_garantii','=','vid_garantiy.id')
                    ->join('ustranenie','mains.ustranenie_id','=','ustranenie.id')
                    ->join('vina','mains.vina_id','=','vina.id')
                    ->join('status','mains.status','=','status.id')
                    ->join('working_statuses','mains.flag','=','working_statuses.id')
                    ->whereBetween('data',[$god.'-01-01',$god.'-12-31'])
                    ->select('mains.*','vid_garantiy.name as name_vid_gara',
                        'ustranenie.name as name_ustranen','vina.name as name_vina','status.name as name_status',
                        'garantiy.name as name_garantiy','working_statuses.name as name_flag','working_statuses.name2 as name2_flag')
                    ->where('flag','=',2)
                    ->orderBy('id','asc')
                    ->get();
            }
            if ($stat==='Удаленные')
            {
                $masiv = DB::table('mains')
                    ->join('garantiy','mains.garantiy_id','=','garantiy.id')
                    ->join('vid_garantiy','mains.vid_garantii','=','vid_garantiy.id')
                    ->join('ustranenie','mains.ustranenie_id','=','ustranenie.id')
                    ->join('vina','mains.vina_id','=','vina.id')
                    ->join('status','mains.status','=','status.id')
                    ->whereBetween('data',[$god.'-01-01',$god.'-12-31'])
                    ->select('mains.*','garantiy.name as name_garantiy','vid_garantiy.name as name_vid_gara',
                        'ustranenie.name as name_ustranen','vina.name as name_vina','status.name as name_status')
                    ->orderBy('id','asc')
                    //->whereNull('flag')
                    ->whereNotNull('mains.deleted_at')
                    ->get();
                /*$masiv = Main::whereBetween('data',[$god.'-01-01',$god.'-12-31'])
                    ->join('garantiy','mains.garantiy_id','=','garantiy.id')
                    ->join('vid_garantiy','mains.vid_garantii','=','vid_garantiy.id')
                    ->join('ustranenie','mains.ustranenie_id','=','ustranenie.id')
                    ->join('vina','mains.vina_id','=','vina.id')
                    ->join('status','mains.status','=','status.id')
                    ->select('mains.*','garantiy.name as name_garantiy','vid_garantiy.name as name_vid_gara',
                        'ustranenie.name as name_ustranen','vina.name as name_vina','status.name as name_status')
                    ->orderBy('id','asc')
                    ->where('flag','=', null)
                    ->where('deleted_at','=', '1')
                    ->get();*/
            }
        }
        else
        {
            $masiv = $masi;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        /*dump($head);
        dump($masiv[0]);exit();*/
        $row=2;
        $col=1;
        $colShapka=1;

        foreach ($head as $hea){
            $sheet->setCellValueByColumnAndRow($colShapka,1,$hea['text']);
            $colShapka++;
            foreach ($masiv as $mas) {
                foreach ($mas as $key => $m){ //short_zakazchik
                    if ($hea['value'] == 'short_zakazchik') {$hea['value'] = 'zakazchik';}
                    if ($hea['value'] == 'short_months') {$hea['value'] = 'months';}
                    if ($hea['value']==$key){
                        //echo $key.' => '.$m.'<br>';
                        $sheet->setCellValueByColumnAndRow($col,$row,$m);
                        $row++;
                    }
                }
            }
            $row=2;
            $col++;
        }
        /*exit();*/

        $sheet->getStyle('A1:M1')->applyFromArray(['font'=>['bold'=>true]]);
        $sheet->getStyle('A1:M500')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(11);
        $sheet->getColumnDimension('C')->setWidth(11);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(10);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(10);
        $sheet->getColumnDimension('M')->setWidth(15);
        $writer = new Xlsx($spreadsheet);
        $put=$put.'/file/отчет-'.$stat.'-'.$god.'.xlsx';
        $writer->save($put);
        $report = new Download;
        $report->title = 'отчет-'.$stat.'-'.$god.'.xlsx';
        $report->mains_id = '1';
        $report->mime = 'application/vnd.ms-excel';
        $report->path = $put;
        $report->size = filesize($put);
        $report->save();

        //dump($report->id);
        $f = Download::findOrFail($report->id);
        $filename = $f->path;//$put.'/file/'.$f->mains_id.$f->title;
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header('Content-Type: '.$f->mime);
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($filename));
        header("Accept-Ranges: bytes");

        return response()->download($filename);
    }
    public function deleteExcel(Request $request)
    {
        $ft = $request->ft;
        $f = Download::where('title',$ft)->get();
        unlink($f[0]->path);
        Download::destroy($f[0]->id);
        return;
    }

    /*public function summaZatraty(Request $request)
    {
        $check= $request->check;
        $months = $request->months;
        $stat = $request->stat;
        $god = $request->god;

        if ($check)
        {// если чек труе то ищет по всем статусам
            if (count($months) != 0)
            {//если выборка есть
                $start = $god . '-' . $months[0] . '-01';
                $end = $god . '-' . $months[count($months) - 1] . '-31';
            }
            else
            {//если выборка нет
                $start = $god . '-' . '01' . '-01';
                $end = $god . '-' . '12' . '-31';
            }
            $summa = DB::table('mains')
                ->whereBetween('data',[$start, $end])
                ->where('mains.deleted_at','=', '0')
                ->select(DB::raw('SUM(mains.zatraty) AS summa'))
                ->get();
            return $summa;
        }
        else
        {
            if (count($months) != 0)
            {
                $start = $god . '-' . $months[0] . '-01';
                $end = $god . '-' . $months[count($months) - 1] . '-31';
            }
            else
            {
                $start = $god . '-' . '01' . '-01';
                $end = $god . '-' . '12' . '-31';
            }
            if ($stat==='В работе'){
                $summa = DB::table('mains')
                    ->whereBetween('data',[$start, $end])
                    ->whereNull('flag')
                    ->where('mains.deleted_at','=', '0')
                    ->select(DB::raw('SUM(mains.zatraty) AS summa'))
                    ->get();
            }
            if ($stat==='Завершенные'){
                $summa = DB::table('mains')
                    ->whereBetween('data',[$start, $end])
                    ->whereNotNull('flag')
                    ->where('mains.deleted_at','=', '0')
                    ->select(DB::raw('SUM(mains.zatraty) AS summa'))
                    ->get();
            }
            if ($stat==='Удаленные'){
                $summa = DB::table('mains')
                    ->whereBetween('data',[$start, $end])
                    ->whereNull('flag')
                    ->where('mains.deleted_at','=', '1')
                    ->select(DB::raw('SUM(mains.zatraty) AS summa'))
                    ->get();
            }
            return $summa;
            //dump($summa[0]->summa);
        }
    }*/

    public function selectMonths(Request $request)
    {
        $check= $request->check;
        $months = $request->months;
        $stat = $request->stat;
        $god = $request->god;
        sort($months);
        $query = '';
        foreach ($months as $key => $value)
        {
            $query = $query . '"' . $god . '-' . $value . '",';
        }
        $queryItog = substr_replace($query,'',-1);

        /*dump($check);
        dump($months);
        dump($stat);
        dump($god);
        //dump($queryItog);
        exit();*/
        if ($check == true)
        { // если выбрано все статусы
            if (count($months) != 0)
            {
                $god = $request->god;
                $start = $god . '-' . $months[0] . '-01';
                $end = $god . '-' . $months[count($months) - 1] . '-31';

                $masiv = Main::whereBetween('data', [$start, $end])
                    ->join('garantiy', 'mains.garantiy_id', '=', 'garantiy.id')
                    ->join('vid_garantiy', 'mains.vid_garantii', '=', 'vid_garantiy.id')
                    ->join('ustranenie', 'mains.ustranenie_id', '=', 'ustranenie.id')
                    ->join('vina', 'mains.vina_id', '=', 'vina.id')
                    ->join('status', 'mains.status', '=', 'status.id')
                    ->join('working_statuses','mains.flag','=','working_statuses.id')
                    ->select('mains.*', 'garantiy.name as name_garantiy', 'vid_garantiy.name as name_vid_gara',
                        'ustranenie.name as name_ustranen', 'vina.name as name_vina', 'status.name as name_status',
                        'working_statuses.name as name_flag','working_statuses.name2 as name2_flag')
                    ->orderBy('data', 'asc')
                    ->get();
                /*$masiv = Main::where('months','LIKE','%'.$queryItog.'%')
                    ->join('garantiy', 'mains.garantiy_id', '=', 'garantiy.id')
                    ->join('vid_garantiy', 'mains.vid_garantii', '=', 'vid_garantiy.id')
                    ->join('ustranenie', 'mains.ustranenie_id', '=', 'ustranenie.id')
                    ->join('vina', 'mains.vina_id', '=', 'vina.id')
                    ->join('status', 'mains.status', '=', 'status.id')
                    ->select('mains.*', 'garantiy.name as name_garantiy', 'vid_garantiy.name as name_vid_gara',
                        'ustranenie.name as name_ustranen', 'vina.name as name_vina', 'status.name as name_status')
                    ->orderBy('data', 'asc')
                    ->get();*/
                //dump($queryItog);
                return $masiv;
                //dump($masiv);
            }
            else
            {
                if ($stat=='В работе')
                {
                    $god = $request->god;

                    $masiv = Main::whereBetween('data', [$god.'-01-01',$god.'-12-31'])
                        ->join('garantiy', 'mains.garantiy_id', '=', 'garantiy.id')
                        ->join('vid_garantiy', 'mains.vid_garantii', '=', 'vid_garantiy.id')
                        ->join('ustranenie', 'mains.ustranenie_id', '=', 'ustranenie.id')
                        ->join('vina', 'mains.vina_id', '=', 'vina.id')
                        ->join('status', 'mains.status', '=', 'status.id')
                        ->join('working_statuses','mains.flag','=','working_statuses.id')
                        ->select('mains.*', 'garantiy.name as name_garantiy', 'vid_garantiy.name as name_vid_gara',
                            'ustranenie.name as name_ustranen', 'vina.name as name_vina', 'status.name as name_status'
                            ,'working_statuses.name as name_flag','working_statuses.name2 as name2_flag')
                        ->orderBy('data', 'asc')
                        ->where('flag','=',1)
                        //->where('mains.deleted_at', '=', '0')
                        ->get();
                    return $masiv;
                }
                if ($stat=='Завершенные')
                {
                    $god = $request->god;

                    $masiv = Main::whereBetween('data', [$god.'-01-01',$god.'-12-31'])
                        ->join('garantiy', 'mains.garantiy_id', '=', 'garantiy.id')
                        ->join('vid_garantiy', 'mains.vid_garantii', '=', 'vid_garantiy.id')
                        ->join('ustranenie', 'mains.ustranenie_id', '=', 'ustranenie.id')
                        ->join('vina', 'mains.vina_id', '=', 'vina.id')
                        ->join('status', 'mains.status', '=', 'status.id')
                        ->join('working_statuses','mains.flag','=','working_statuses.id')
                        ->select('mains.*', 'garantiy.name as name_garantiy', 'vid_garantiy.name as name_vid_gara',
                            'ustranenie.name as name_ustranen', 'vina.name as name_vina', 'status.name as name_status'
                            ,'working_statuses.name as name_flag','working_statuses.name2 as name2_flag')
                        ->orderBy('data', 'asc')
                        ->where('flag','=',2)
                        //->where('mains.deleted_at', '=', '0')
                        ->get();
                    return $masiv;
                }
                if ($stat=='Удаленные')
                {
                    $god = $request->god;

                    $masiv = Main::onlyTrashed()->whereBetween('data', [$god.'-01-01',$god.'-12-31'])
                        ->join('garantiy', 'mains.garantiy_id', '=', 'garantiy.id')
                        ->join('vid_garantiy', 'mains.vid_garantii', '=', 'vid_garantiy.id')
                        ->join('ustranenie', 'mains.ustranenie_id', '=', 'ustranenie.id')
                        ->join('vina', 'mains.vina_id', '=', 'vina.id')
                        ->join('status', 'mains.status', '=', 'status.id')
                        ->join('working_statuses','mains.flag','=','working_statuses.id')
                        ->select('mains.*', 'garantiy.name as name_garantiy', 'vid_garantiy.name as name_vid_gara',
                            'ustranenie.name as name_ustranen', 'vina.name as name_vina', 'status.name as name_status'
                            ,'working_statuses.name as name_flag','working_statuses.name2 as name2_flag')
                        ->orderBy('data', 'asc')
                        //->whereNull('flag')
                        //->where('mains.deleted_at', '=', '1')
                        ->get();
                    return $masiv;
                }
            }
        }
        else
        {// если выбрано по текущему статусу
            if (count($months) != 0)
            {
                if ($stat=='В работе')
                {
                    $god = $request->god;
                    $start = $god . '-' . $months[0] . '-01';
                    $end = $god . '-' . $months[count($months) - 1] . '-31';

                    $masiv = Main::whereBetween('data', [$start, $end])
                        ->join('garantiy', 'mains.garantiy_id', '=', 'garantiy.id')
                        ->join('vid_garantiy', 'mains.vid_garantii', '=', 'vid_garantiy.id')
                        ->join('ustranenie', 'mains.ustranenie_id', '=', 'ustranenie.id')
                        ->join('vina', 'mains.vina_id', '=', 'vina.id')
                        ->join('status', 'mains.status', '=', 'status.id')
                        ->join('working_statuses','mains.flag','=','working_statuses.id')
                        ->select('mains.*', 'garantiy.name as name_garantiy', 'vid_garantiy.name as name_vid_gara',
                            'ustranenie.name as name_ustranen', 'vina.name as name_vina', 'status.name as name_status',
                            'working_statuses.name as name_flag','working_statuses.name2 as name2_flag')
                        ->orderBy('data', 'asc')
                        ->where('flag','=',1)
                        //->where('mains.deleted_at', '=', '0')
                        ->get();
                    return $masiv;
                }
                if ($stat=='Завершенные')
                {
                    $god = $request->god;
                    $start = $god . '-' . $months[0] . '-01';
                    $end = $god . '-' . $months[count($months) - 1] . '-31';

                    $masiv = Main::whereBetween('data', [$start, $end])
                        ->join('garantiy', 'mains.garantiy_id', '=', 'garantiy.id')
                        ->join('vid_garantiy', 'mains.vid_garantii', '=', 'vid_garantiy.id')
                        ->join('ustranenie', 'mains.ustranenie_id', '=', 'ustranenie.id')
                        ->join('vina', 'mains.vina_id', '=', 'vina.id')
                        ->join('status', 'mains.status', '=', 'status.id')
                        ->join('working_statuses','mains.flag','=','working_statuses.id')
                        ->select('mains.*', 'garantiy.name as name_garantiy', 'vid_garantiy.name as name_vid_gara',
                            'ustranenie.name as name_ustranen', 'vina.name as name_vina', 'status.name as name_status',
                            'working_statuses.name as name_flag','working_statuses.name2 as name2_flag')
                        ->orderBy('data', 'asc')
                        ->where('flag','=',2)
                        //->where('mains.deleted_at', '=', '0')
                        ->get();
                    return $masiv;
                }
                if ($stat=='Удаленные')
                {
                    $god = $request->god;
                    $start = $god . '-' . $months[0] . '-01';
                    $end = $god . '-' . $months[count($months) - 1] . '-31';

                    $masiv = Main::onlyTrashed()->whereBetween('data', [$start, $end])
                        ->join('garantiy', 'mains.garantiy_id', '=', 'garantiy.id')
                        ->join('vid_garantiy', 'mains.vid_garantii', '=', 'vid_garantiy.id')
                        ->join('ustranenie', 'mains.ustranenie_id', '=', 'ustranenie.id')
                        ->join('vina', 'mains.vina_id', '=', 'vina.id')
                        ->join('status', 'mains.status', '=', 'status.id')
                        ->join('working_statuses','mains.flag','=','working_statuses.id')
                        ->select('mains.*', 'garantiy.name as name_garantiy', 'vid_garantiy.name as name_vid_gara',
                            'ustranenie.name as name_ustranen', 'vina.name as name_vina', 'status.name as name_status',
                            'working_statuses.name as name_flag','working_statuses.name2 as name2_flag')
                        ->orderBy('data', 'asc')
                        //->whereNull('flag')
                        //->where('mains.deleted_at', '=', '1')
                        ->get();
                    return $masiv;
                }
            }
            else
            {
                if ($stat=='В работе')
                {
                    $god = $request->god;

                    $masiv = Main::whereBetween('data', [$god.'-01-01',$god.'-12-31'])
                        ->join('garantiy', 'mains.garantiy_id', '=', 'garantiy.id')
                        ->join('vid_garantiy', 'mains.vid_garantii', '=', 'vid_garantiy.id')
                        ->join('ustranenie', 'mains.ustranenie_id', '=', 'ustranenie.id')
                        ->join('vina', 'mains.vina_id', '=', 'vina.id')
                        ->join('status', 'mains.status', '=', 'status.id')
                        ->join('working_statuses','mains.flag','=','working_statuses.id')
                        ->select('mains.*', 'garantiy.name as name_garantiy', 'vid_garantiy.name as name_vid_gara',
                            'ustranenie.name as name_ustranen', 'vina.name as name_vina', 'status.name as name_status',
                            'working_statuses.name as name_flag','working_statuses.name2 as name2_flag')
                        ->orderBy('data', 'asc')
                        ->where('flag','=',1)
                        //->where('mains.deleted_at', '=', '0')
                        ->get();
                    return $masiv;
                }
                if ($stat=='Завершенные')
                {
                    $god = $request->god;

                    $masiv = Main::whereBetween('data', [$god.'-01-01',$god.'-12-31'])
                        ->join('garantiy', 'mains.garantiy_id', '=', 'garantiy.id')
                        ->join('vid_garantiy', 'mains.vid_garantii', '=', 'vid_garantiy.id')
                        ->join('ustranenie', 'mains.ustranenie_id', '=', 'ustranenie.id')
                        ->join('vina', 'mains.vina_id', '=', 'vina.id')
                        ->join('status', 'mains.status', '=', 'status.id')
                        ->join('working_statuses','mains.flag','=','working_statuses.id')
                        ->select('mains.*', 'garantiy.name as name_garantiy', 'vid_garantiy.name as name_vid_gara',
                            'ustranenie.name as name_ustranen', 'vina.name as name_vina', 'status.name as name_status',
                            'working_statuses.name as name_flag','working_statuses.name2 as name2_flag')
                        ->orderBy('data', 'asc')
                        ->where('flag','=',2)
                        //->where('mains.deleted_at', '=', '0')
                        ->get();
                    return $masiv;
                }
                if ($stat=='Удаленные')
                {
                    $god = $request->god;

                    $masiv = Main::onlyTrashed()->whereBetween('data', [$god.'-01-01',$god.'-12-31'])
                        ->join('garantiy', 'mains.garantiy_id', '=', 'garantiy.id')
                        ->join('vid_garantiy', 'mains.vid_garantii', '=', 'vid_garantiy.id')
                        ->join('ustranenie', 'mains.ustranenie_id', '=', 'ustranenie.id')
                        ->join('vina', 'mains.vina_id', '=', 'vina.id')
                        ->join('status', 'mains.status', '=', 'status.id')
                        ->join('working_statuses','mains.flag','=','working_statuses.id')
                        ->select('mains.*', 'garantiy.name as name_garantiy', 'vid_garantiy.name as name_vid_gara',
                            'ustranenie.name as name_ustranen', 'vina.name as name_vina', 'status.name as name_status',
                            'working_statuses.name as name_flag','working_statuses.name2 as name2_flag')
                        ->orderBy('data', 'asc')
                        //->whereNull('flag')
                        //->where('mains.deleted_at', '=', '1')
                        ->get();
                    return $masiv;
                }
            }
        }
    }

    public function allEntries(Request $request){

        $god = $request->god;
        $masiv = Main::whereBetween('data',[$god.'-01-01',$god.'-12-31'])
            ->join('garantiy','mains.garantiy_id','=','garantiy.id')
            ->join('vid_garantiy','mains.vid_garantii','=','vid_garantiy.id')
            ->join('ustranenie','mains.ustranenie_id','=','ustranenie.id')
            ->join('vina','mains.vina_id','=','vina.id')
            ->join('status','mains.status','=','status.id')
            ->join('working_statuses','mains.flag','=','working_statuses.id')
            ->select('mains.*','garantiy.name as name_garantiy','vid_garantiy.name as name_vid_gara',
                'ustranenie.name as name_ustranen','vina.name as name_vina','status.name as name_status',
                'working_statuses.name as name_flag','working_statuses.name2 as name2_flag')
            ->orderBy('data','asc')
            ->get();
        return $masiv;
    }
    public function start(Request $request){

        $god = $request->god;
        $masiv = Main::whereBetween('data',[$god.'-01-01',$god.'-12-31'])
            ->join('garantiy','mains.garantiy_id','=','garantiy.id')
            ->join('vid_garantiy','mains.vid_garantii','=','vid_garantiy.id')
            ->join('ustranenie','mains.ustranenie_id','=','ustranenie.id')
            ->join('vina','mains.vina_id','=','vina.id')
            ->join('status','mains.status','=','status.id')
            ->join('working_statuses','mains.flag','=','working_statuses.id')
            ->select('mains.*','vid_garantiy.name as name_vid_gara',
                'ustranenie.name as name_ustranen','vina.name as name_vina','status.name as name_status',
                'garantiy.name as name_garantiy','working_statuses.name as name_flag','working_statuses.name2 as name2_flag')
            ->where('flag','=',1)
            ->orderBy('data','asc')
            ->get();
        //dump($masiv);
        return $masiv;
    }

    public function chartStart(Request $request){

        $month = $request->month;
        $god = $request->god;
        $kvartal = $request->kvartal;
        $arr = array();
        $resultEnd = array();
        //dump($month);
        if (gettype($month) == 'string')
        { //превращаем в ARRAY
            $months = json_decode($month);
            foreach ($months as $key => $value)
            {
                $time = $value;
                $value = $god.'-'.$time;
                $months[$key]=$value;
            }
        }
        else
        {
            $months = $month;
            foreach ($months as $key => $value)
            {
                $time = $value;
                $value = $god.'-'.$time;
                $months[$key]=$value;
            }
        }
        sort($months);

        $num = 0;
        foreach ($months as $key => $value)
        {
            //echo $key.' = '.$value.'<br>';
            $masiv = Main::where('months','LIKE','%'.$value.'%')
                ->join('vid_garantiy','mains.vid_garantii','=','vid_garantiy.id')
                ->join('vina','mains.vina_id','=','vina.id')
                ->select('mains.*','vid_garantiy.name as name_vid_gara','vina.name as name_vina') //'prikaz_gar','zakazchik','prikaz','zatraty','vina_id','vid_garantii','months',
                ->get();
            foreach ($masiv as $item)
            {
                // добавляем в массив
                $arr[$num] = $item;
                $num++;
            }
        }
        // удаляем дубли и возвращаем первый набор
        $result = array_unique($arr);
        // упорядочиваем
        $num = 0;
        foreach ($result as $res)
        {
            $resultEnd[$num] = $res;
            $num++;
        }
// --------------------------------------------------------------
        $vid_garantii = Vidgarantiy::all();
        $vid_gar = array();
        $vidGarEnd = array();
        // формируем массив
        for ($i = 1; $i<count($vid_garantii)+1; $i++)
        {
            array_push($vid_gar, ['vidgar' => 0, 'vidgs' => $vid_garantii[$i-1]->name]);
        }
        // складываем и заполняем в массив
        foreach ($result as $res)
        {
            $vid_gar[$res->vid_garantii-1]['vidgar'] = $vid_gar[$res->vid_garantii-1]['vidgar'] + $res->zatraty;
        }

        // с 0 в значении убираем
        foreach ($vid_gar as $key => $vg)
        {
            if ($vg['vidgar'] == 0)
            {
                unset($vid_gar[$key]);
            }
        }
        // упорядочиваем
        $num = 0;
        foreach ($vid_gar as $vg)
        {
            $vidGarEnd[$num] = $vg;
            $num++;
        }
        //----------------------------------------------------------------------------------------
        //dump($kvartal);
        $totalFakt=0;
        $quarters = Purpose::find($kvartal);
        foreach ($quarters as $quar)
        {
            $totalFakt = $totalFakt + $quar['fakt'];
        }
        //dump($totalFakt);

        $bigMasiv = array('table1'=>$resultEnd, 'table2'=>$vidGarEnd, 'purpose'=>$totalFakt);

        return $bigMasiv;
    }
}
