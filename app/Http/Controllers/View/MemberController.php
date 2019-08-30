<?php

namespace App\Http\Controllers\View;

use App\Tool\Validate\ValidateCode;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
   public function toLogin($value=''){
       return view('login');

   }
   public function toRegister($value=''){
       return view('register');
   }
}
