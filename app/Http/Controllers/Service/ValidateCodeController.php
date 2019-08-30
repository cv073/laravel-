<?php

namespace App\Http\Controllers\Service;


use Illuminate\Http\Request;
use App\Tool\Validate\ValidateCode;
use App\Http\Controllers\Controller;
use App\Tool\SMS\SendTemplateSMS;
use App\Entity\TempPhone;
use App\Models\M3Result;
use App\Entity\TempEmail;
use App\Entity\Member;




class ValidateCodeController extends Controller
{
   public function create(Request $request)
   {
      $validateCode = new ValidateCode;
      $request->session()->put('validate_code',$validateCode->getCode());
      return $validateCode->doimg();
   }

   public function sendSMS(Request $request){
       $m3_result = new M3Result;

       $phone = $request->input('phone','');
       if($phone == ''){
         $m3_result->status = 1;
         $m3_result->message = '手机号码不能为空';

       return $m3_result->toJson();       }

    $SendTemplateSMS = new SendTemplateSMS;
    $code='';

    $charset = '1234567890';
       $_len = strlen($charset) - 1;
       for ($i = 0;$i < 6;++$i) {
           $code .= $charset[mt_rand(0, $_len)];
       }

       $m3_result=$SendTemplateSMS->sendTemplateSMS($phone,array($code,60),1);
       if($m3_result->status == 0){
           $tempPhone = TempPhone::where('phone',$phone)->first();
           if($tempPhone == null){
               $tempPhone = new TempPhone;
           }

           $tempPhone->phone = $phone;
           $tempPhone->code = $code;
           $tempPhone->deadline = date('Y-m-d H:i:s',time() + 60*60);
           $tempPhone->save();
       }



       return $m3_result->toJson();

   }
   public function validateEmail(Request $request)
   {
       $member_id = $request->input('member_id','');
       $code = $request->input('code','');
       if($member_id == ''|| $code == ''){
           return '验证异常';
       }
       $tempEmail = TempEmail::where('member_id',$member_id)->first();
       if($tempEmail == null){
           return "验证异常";
       }
       if($tempEmail->code == $code){

//           dump(strtotime($tempEmail->deadline));die;
//           dump($tempEmail->deadline);die;
           if(time() > strtotime($tempEmail->deadline)){
               return '该链接已经失效';
           }
           $member = Member::find($member_id);
           $member->active = 1;
           $member->save();

           return redirect('/login');
       }else{
           return '该链接已经失效';
       }


   }

}
