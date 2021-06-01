<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ExpertsCallback;
use Carbon\Carbon;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App;
use Illuminate\Support\Facades\Input;


class ExpertsCallbackController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"    => "required",
            "surname"    => "required",
            "phone"    => "required",
            "email"    => "required|email",
            "birth_date"    => "required|date",
            'documents.*' => 'mimes:doc,pdf,docx,zip,png,jpg,jpeg'
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $item = new ExpertsCallback();
        $item->name = $request->name;
        $item->surname = $request->surname;
        $item->third_name = $request->third_name;
        $item->birth_date = $request->birth_date;
        $item->address = $request->address;
        $item->languages = $request->langs;
        $item->level_of_knowing = $request->level_of_knowing;
        $item->science_degree = $request->science_degree;
        $item->science_rank = $request->science_rank;
        $item->fax = $request->fax;
        $item->email = $request->email;
        $item->work_place = $request->work_place;
        $item->job = $request->job;
        $item->teaching_experience = $request->teaching_experience;
        $item->rewards = $request->rewards;
        $item->science_sphere = $request->science_sphere;
        $item->expert_spheres = $request->expert_spheres;
        $item->phone = $request->phone;
        $data = [];

        $email_data = '';
        if($request->hasfile('documents'))
        {
            foreach($request->file('documents') as $file)
            {

                $name=time().'_'.$file->getClientOriginalName();
                $file->move(public_path().'/files/', $name);
                $data[] = $name;
                $email_data .= 'https://iaar.agency/files/'.$name.'</br>';
            }
        }
        $item->documents = json_encode($data,true);
        $item->save();
        $link = 'https://iaar.agency/admin/naar/experts_callbacks/'.$item->id;
        $lang =  $request->lang;
        switch ($lang)
        {
            case 'ru':
                $success = 'Ваша заявка успешно принята!';
                break;
            case 'kz':
                $success = 'Сіздің өтінішіңіз сәтті қабылданды!';
                break;
            case 'en':
                $success = 'Your application has been successfully accepted!';
                break;
            default:
                $success = 'Ваша заявка успешно принята!';
                break;
        }
        $to = "application@iaar.agency"; /*Укажите адрес, га который должно приходить письмо*/
        $sendfrom   = "info@iaar.kz"; /*Укажите адрес, с которого будет приходить письмо, можно не настоящий, нужно для формирования заголовка письма*/
        $headers  = "From: " . strip_tags($sendfrom) . "\r\n";
        $headers .= "Reply-To: ". strip_tags($sendfrom) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html;charset=utf-8 \r\n";
        $subject = "Новая завяка эксперта";
        $message = "Заявка эксперта <br>
        <b>Фамилия :</b> $item->surname <br>
          <b>Имя :</b> $item->name  <br>
        <b>Отчество:</b> $item->third_name <br>
        <b>Дата рождения:</b> $item->birth_date <br>
        <b>Адрес:</b> $item->address <br>
        <b>Языки:</b> $item->languages <br>
        <b>Уровень знания:</b> $item->level_of_knowing <br>
        <b>Ученые степени:</b> $item->science_degree <br>
        <b>Ученый ранг:</b> $item->science_rank <br>
        <b>Факс:</b> $item->fax <br>
        <b>Должность:</b> $item->job <br>
        <b>Опыт преподавания:</b> $item->teaching_experience <br>
        <b>награды:</b> $item->rewards <br>
        <b>Ученая сфера:</b> $item->science_sphere <br>
        <b>Экспертная сфера:</b> $item->expert_spheres <br>
        <b>телефон:</b> $item->phone <br>
        <b>Место работы:</b> $item->work_place <br>
        <b>Email:</b> $item->email <br>
        <b>Посмотреть заявку:</b> $link <br>";
        $send = mail($to, $subject, $message, $headers);
        return redirect()->back()->with('status',$success);
    }

}
