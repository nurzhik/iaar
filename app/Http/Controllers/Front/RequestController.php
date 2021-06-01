<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\AccrRequest;
use App;
use Illuminate\Support\Facades\Input;



class RequestController extends Controller
{


    public function getRequestPage($lang = null)
    {
        return view('front.requests.index',[
            'lang' => $lang
        ]);
    }
    public function postRequestForm( Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"    => "required",
            'email' => "required|email",
            'file_at' =>"file|max:10240"
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new AccrRequest();
        $item->name = $request->name;
        $item->email = $request->email;
        $item->message = $request->message;
        if(Input::file('file_at') !== null)
        {
            $file = Input::file('file_at');
            $file_ex = $file->getClientOriginalExtension();
            $newname = time().$file->getClientOriginalName();
            $file->move('uploads', $newname);

            $item->file = '/uploads/'.$newname;
        }


        $item->save();
        $link = 'https://iaar.agency/admin/requests/'.$item->id;
        $to = "application@iaar.agency"; /*Укажите адрес, га который должно приходить письмо*/
        $sendfrom   = "info@iaar.kz"; /*Укажите адрес, с которого будет приходить письмо, можно не настоящий, нужно для формирования заголовка письма*/
        $headers  = "From: " . strip_tags($sendfrom) . "\r\n";
        $headers .= "Reply-To: ". strip_tags($sendfrom) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html;charset=utf-8 \r\n";
        $subject = "Заявка на аккредитацию с сайта iaar.agency";
        $message = "Заявка на аккредитацию с сайта iaar.agency <br>
        <b>Имя:</b> $item->name <br>
        <b>Email:</b> $item->email <br>
        <b>Текст:</b> $item->message <br>
        <b>Ссылка:</b>  $link <br>";
        $send = mail($to, $subject, $message, $headers);
        $lang =  $request->lang;
       // dd($lang);
        if($lang == 'kz') {
            $status = "Сіздің өтінішіңіз сәтті қабылданды! ";
        }else if($lang=='en') {
            $status = "Your application has been successfully accepted!";
        }else{
            $status = "Ваша заявка успешно принята!";
        }
        // 
         // 
         // 
         return redirect()->back()->with(['status' => $status]);

    }
    public function postRequestCallback( Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"    => "required",
           
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
    
        
        $to = "application@iaar.agency"; /*Укажите адрес, га который должно приходить письмо application@iaar.agency*/
        $sendfrom   = "info@iaar.kz"; /*Укажите адрес, с которого будет приходить письмо, можно не настоящий, нужно для формирования заголовка письма*/
        $headers  = "From: " . strip_tags($sendfrom) . "\r\n";
        $headers .= "Reply-To: ". strip_tags($sendfrom) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html;charset=utf-8 \r\n";
        $subject = "Заявка на обратную свзязь с сайта iaar.agency";
        $message = "Заявка на обратную свзязь с сайта iaar.agency <br>
        <b>Имя:</b>  $request->name <br>
        <b>Email:</b> $request->phone <br>
        <b>Текст:</b> $request->message <br>";
        $send = mail($to, $subject, $message, $headers);
        $lang =  $request->lang;
       // dd($lang);
        if($lang == 'kz') {
            $status = "Сіздің өтінішіңіз сәтті қабылданды! ";
        }else if($lang=='en') {
            $status = "Your application has been successfully accepted!";
        }else{
            $status = "Ваша заявка успешно принята!";
        }
        // 
         // 
         // 
         return redirect()->back()->with(['status' => $status]);

    }
}
