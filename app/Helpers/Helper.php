<?php
use App\Permission;
use App\Setting;
use App\Reservation;
use App\Order;
use App\Room;
use App\OrderHistory;
use App\Unit,App\RoomType,App\Customer;
use DB;
function lang_trans($key){
    $defaultLang = 'en';
    if(isset(Session::get('settings')['site_language'])){
        $defaultLang = Session::get('settings')['site_language'];
    }
    if(isset(config('lang_admin')[$key][$defaultLang])){
        return config('lang_admin')[$key][$defaultLang];
    }
    return $key;
}

function setSettings(){
    $settings = Setting::pluck('value','name');
    Session::put('settings', $settings);
    return $settings;
}
function getSettings($clm=null){
    // if(Session::get('settings')){
    //     $settings = Session::get('settings');
    // } else {
        $settings = setSettings();
    //}

    if($clm==null){
        return $settings;
    }
    if(isset($settings[$clm])){
        return $settings[$clm];
    }
    return '';
}
function getUnits(){
    return Unit::where('is_deleted',0)->pluck('name','id');
}
function getRoomTypesList(){
    return RoomType::whereStatus(1)->whereIsDeleted(0)->orderBy('title','ASC')->pluck('title','id');
}
function getCustomerList(){
    return Customer::select('id',DB::raw('CONCAT(name, " (", mobile,")") AS display_text'))->whereIsDeleted(0)->orderBy('name','ASC')->pluck('display_text','id','name');
}
function getCurrencyList(){
    $list = config('currencies')['CURRENCY_LIST'];
    $currencies = [];
    foreach($list as $val){
        $currencies[$val['code']] = $val['code'].' ('.$val['country'].')';
    }
    return $currencies;
}
function getCurrencySymbol($isCode=false){
    $settings = getSettings();
    if(isset($settings['currency_symbol']) && $settings['currency_symbol']!='' && !$isCode){
        return $settings['currency_symbol'];
    }
    if(isset($settings['currency']) && $settings['currency']!=''){
        return $settings['currency'];
    }
    return ($isCode) ? 'USD' : '$';
}
function getCountryList(){
    $list = config('constants.COUNTRY_LIST');
    foreach($list as $k=>$val){
        $countries[$val['name']] = $val['name'];
    }
    return $countries;
}
function getMenuPermission(){
    
  
    $permissions = Permission::where('permission_type','menu')->get();
    $roles = [1=>'super_admin', 2=>'admin', 3=>'receptionist', 5=>'kitchen'];
    $permissionArr = [];
    if($permissions){
        foreach($permissions as $k=>$val){
            $permissionArr[$val->slug] = $val->{$roles[Auth::user()->role_id]};
        }
    }
    return $permissionArr;
}
function getRoutePermission(){
    
   
    $permissions = Permission::where('permission_type','route')->get();
    $roles = [1=>'super_admin', 2=>'admin', 3=>'receptionist', 5=>'kitchen'];
    $permissionArr = [];
    if($permissions){
        foreach($permissions as $k=>$val){

           $permissionArr[$val->slug] = $val->{$roles[Auth::user()->role_id]};
        }
    }
    return $permissionArr;
}

function genRandomValue($length=5,$type='digit',$prefix=null){
    if($type=='digit'){
        $characters = date('Ymd').'123456789987654321564738291918273645953435764423'.time();
    } else {
        $characters = date('Ymd').'123456789TRANSACTIONID987654321ABCDEFGHIJKLMNOPQRSTUVWXYZ111BHEEMSWAMI9OO14568O8BIKANER1RAJASTHAN334OO1'.time();
    }
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $prefix.$randomString;
}

function getNextPrevDate($isDate='prev', $days=null){
    if($isDate=='prev'){
        $symbol = '-';
    } else {
        $symbol = '+';
    }
    if($days==null){
        $days = config('constants.REC_DAYS');
    }
    return date('Y-m-d', strtotime(date('Y-m-d'). $symbol.$days.' days'));
}

function dateConvert($date=null,$format=null){
    if($date==null)
        return date($format);
    if($format==null)
        return date('Y-m-d',strtotime($date));
    else
        return date($format,strtotime($date));
}

function timeConvert($time,$format=null){
    if($format==null)
        return date('H:i:s',strtotime($time));
    else
        return date($format,strtotime($time));
}
function timeFormatAmPm($time=null){
    if($time==null || $time==''){
        return '';
    }
    $exp = explode(' ', $time);
    $temp = date_parse($exp[0]);
    $temp['minute'] = str_pad($temp['minute'], 2, '0', STR_PAD_LEFT);
    return date('h:i a', strtotime($temp['hour'] . ':' . $temp['minute']));
}

function limit_text($text, $limit) {
  if (strlen($text) > $limit) {
        $text = substr($text, 0, $limit) . '...';
  }
  return $text;
}
function limit_words($string, $word_limit)
{
    if (str_word_count($string, 0) > $word_limit) {
        $words = explode(" ",$string);
        return implode(" ",array_splice($words,0,$word_limit)).'...';
    }
    return $string;
}

function checkFile($filename,$path,$default=null) {
    $src=url('public/images/'.$default);
    $path='public/'.$path;
    if($filename != NULL && $filename !='' && $filename != '0')
    {
        $file_path = app()->basePath($path.$filename);
        if(File::exists($file_path)){
            $src=url($path.$filename);
        }
    }
    return $src;
}
function unlinkImg($img,$path) {
    if($img !=null || $img !='')
    {
        $path='public/'.$path;
        $image_path = app()->basePath($path.$img);
        if(File::exists($image_path))
            unlink($image_path);
    }
}

function getNextInvoiceNo($type=null){
    if($type=='orders'){
        $data = Order::whereNotNull('invoice_num')->orderBy('invoice_num','DESC')->first();
    } else {
        $data = Reservation::whereNotNull('invoice_num')->orderBy('invoice_num','DESC')->first();
    }

    if($data){
        $nextNum = $data->invoice_num+1;
    } else {
        $nextNum ='10001';
    }
    return $nextNum;
}

function getInvoiceNumber($id)
{
    $r=Reservation::where('id',$id)->first();
    $mid=$r->mid;
    $s=Setting::where('name','hotel_name')->first();
    $name=$s->value;
    $words = explode(" ", $name);
   $acronym = "";
   foreach ($words as $w) {
   $acronym .= $w[0];
    }
    
    return $acronym.$mid;
    
}

function getStatusBtn($status){
    $txt = '';
    if(isset(config('constants.LIST_STATUS')[$status])){
        $txt = config('constants.LIST_STATUS')[$status];
    }
    if($status==1){
        return '<button type="button" class="btn btn-success btn-xs">'.$txt.'</button>';
    } else {
        return '<button type="button" class="btn btn-default btn-xs">'.$txt.'</button>';
    }
}
function getTableNums($excOrderId=0){
    $bookedTablesQuery =  OrderHistory::where('is_book',1);
    if($excOrderId>0){
        $bookedTablesQuery->where('order_id','<>',$excOrderId);
    }
    $bookedTables =  $bookedTablesQuery->pluck('table_num')->toArray();
    $tableNums = [];
    for($i=1; $i<=50; $i++){
        if(!in_array($i,$bookedTables)) $tableNums[$i] = $i;
    }
    return $tableNums;
}

function isTableBook($tableNum=0){
    return OrderHistory::where('table_num',$tableNum)->where('is_book',1)->orderBy('id','DESC')->first();
}
function getOrderInfo($id){
    return Order::where('reservation_id',$id)->first();
}

function gstCalc($amount,$type,$gstPerc,$cgstPerc){
    if($type=='room_amount'){

        if($amount>999){
            $total_inc_perc = ($gstPerc+$cgstPerc)/100+1;
            $tot_inc_amount = ($amount)/($total_inc_perc);
            $totl_sub_inc_amount = ($amount)-($tot_inc_amount);
            $gstAmount = ($totl_sub_inc_amount)/2;
            $cgstAmount = ($totl_sub_inc_amount)/2;
        }
     else {
        $total_inc_perc = ($gstPerc+$cgstPerc)/100+1;
        $tot_inc_amount = ($amount)/($total_inc_perc);
        $totl_sub_inc_amount = ($amount)-($tot_inc_amount);

        $gstAmount = ($totl_sub_inc_amount)/2;

        $cgstAmount = ($totl_sub_inc_amount)/2;
    }
}
else
{

    if($amount>999){
        $total_inc_perc = ($gstPerc+$cgstPerc)/100+1;
        $tot_inc_amount = ($amount)/($total_inc_perc);
        $totl_sub_inc_amount = ($amount)-($tot_inc_amount);
        $gstAmount = ($totl_sub_inc_amount)/2;
        $cgstAmount = ($totl_sub_inc_amount)/2;
    }
    else {
        $total_inc_perc = ($gstPerc+$cgstPerc)/100+1;
        $tot_inc_amount = ($amount)/($total_inc_perc);
        $totl_sub_inc_amount = ($amount)-($tot_inc_amount);
        $gstAmount = ($totl_sub_inc_amount)/2;

        $cgstAmount = ($totl_sub_inc_amount)/2;
    }
}
return ['gst'=>$gstAmount, 'cgst'=>$cgstAmount];

}

function calcFinalAmount($val){
          $totalRoomAmountGst = $totalRoomAmountCGst = $totalRoomAmountDiscount = 0;
          if($val->amount_json!=null) {
            $jsonData = json_decode($val->amount_json);
            if(isset($jsonData->total_room_amount_gst)) $totalRoomAmountGst = $jsonData->total_room_amount_gst;
            if(isset($jsonData->total_room_amount_cgst)) $totalRoomAmountCGst = $jsonData->total_room_amount_cgst;
            if(isset($jsonData->room_amount_discount)) $totalRoomAmountDiscount = $jsonData->room_amount_discount;
          }

          $durOfStay = $val->duration_of_stay;
          $perRoomPrice = $val->per_room_price;
          $roomQty = $val->room_qty;

          if($perRoomPrice == 0.0)
          {
            $totalAmount =$val->booking_payment;
          }
          else
          {
            $totalAmount = ($durOfStay * $perRoomPrice * $roomQty);
          }
          if($totalRoomAmountGst == 0)
          {
            $gstPerc =$val->get_perc;
            $cgstPerc = $val->cgst_perc;
            $gstCal = gstCalc($totalAmount,'room_gst',$gstPerc,$cgstPerc);
            $totalRoomAmountGst = $gstCal['gst'];

            $totalRoomAmountCGst = $gstCal['cgst'];
          }



          $advancePayment = $val->advance_payment;
          $finalRoomAmount = $totalAmount+$totalRoomAmountGst+$totalRoomAmountCGst-$advancePayment-$totalRoomAmountDiscount;
          $totalOrderAmountGst = $totalOrderAmountCGst = $totalOrderAmountDiscount = $orderGst = $orderCGst = 0;
          $orderInfo = getOrderInfo($val->id);
          if($orderInfo){
            $orderGst = $orderInfo->gst_perc;
            $orderCGst = $orderInfo->cgst_perc;
            $totalOrderAmountGst = $orderInfo->gst_amount;
            $totalOrderAmountCGst = $orderInfo->cgst_amount;
            $totalOrderAmountDiscount = $orderInfo->discount;
          }

          $totalOrdersAmount = 0;
          if($val->orders_items->count()>0){
            foreach($val->orders_items as $k=>$orderVal){
                $totalOrdersAmount = $totalOrdersAmount + ($orderVal->item_qty*$orderVal->item_price);
            }
          }
          $finalOrderAmount = ($totalOrdersAmount+$totalOrderAmountGst+$totalOrderAmountCGst-$totalOrderAmountDiscount);

          return [
            'totalRoomAmountGst' => $totalRoomAmountGst,
            'totalRoomAmountCGst' => $totalRoomAmountCGst,
            'totalRoomAmountDiscount'=> $totalRoomAmountDiscount,
            'finalRoomAmount'=> $finalRoomAmount,

            'totalOrderAmountGst'=>$totalOrderAmountGst,
            'totalOrderAmountCGst'=>$totalOrderAmountCGst,
            'totalOrderAmountDiscount'=>$totalOrderAmountDiscount,
            'finalOrderAmount'=>$finalOrderAmount,

          ];
}

function getMaxDiscount($amount,$perc=20){
    $maxDiscount = ($perc/100)*$amount;
    return $maxDiscount;
}
function numberFormat($num){
        return sprintf('%0.2f',$num);
}
function getIndianCurrency(float $number){
    $negative = false;
    if($number < 0){
        $negative = true;
        $number = abs($number);
    }
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? " Point " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) : '';
    $amount =  ($Rupees ? $Rupees : '') . $paise . ' '.getCurrencySymbol(true);
    if($negative){
        $amount = '(Minus) '. $amount;
    }
    return $amount;
}
function getBookRoomId($room_num)
{
    $data = Reservation::where('room_num',$room_num)->whereNull('check_out')->pluck('id')->first();
    if($data)
    {
        return $data;
    }
    else{
        return 0;
    }

}
function get_payment_mode_data($payment_mode)
{
    $data = DB::table('daily_report')->pluck($payment_mode);
    return $data[0];
}

function centralDataInsert($data)
{
    $url = "https://dashboard.f9hotels.com/api/index";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    $res = curl_exec($curl);
    curl_close($curl);
}

function centralDataInsertf9($data)
{
    // return $data; die;
    $url = "https://f9hotels.com/api/newuserinsert";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    $res = curl_exec($curl);
    curl_close($curl);
    return $res;
}
