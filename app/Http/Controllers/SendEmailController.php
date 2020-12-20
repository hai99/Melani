<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Mail\SendMail;
use Mail;
use App\Models\Contact;

class SendEmailController extends Controller
{
    public function index(){
        return view('user/contact-us');
    }

    public function send(Request $request){
        $rules = [
            'name' => 'required',
            'phoneNumber' => 'required',
            'email' => 'required|email',
            'conSubject' => 'required',
            'conMessage' => 'required',
        ];
        $messages = [
            'name.required' => 'Tên không được để trống',
            'email.required' => 'Email không được để trống',
            'phoneNumber.required' => 'Số điện thoại không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'conSubject.required' => 'Tiêu đề không được để trống',
            'conMessage.required' => 'Nội dung không được để trống',
        ];
        $errors = Validator::make($request->all(),$rules,$messages);
        if($errors->fails()){
            return response()->json(['errors'=>$errors->errors()->all()]);
        }else{
            Mail::send('email.contact',[
            'name' => $request->name,
            'email' => $request->email,
            'phoneNumber' => $request->phoneNumber,
            'conSubject' => $request->conSubject,
            'conMessage' => $request->conMessage,
            ],function($mail) use($request){
                $mail->to('melanibeautyshop@gmail.com',$request->name);
                $mail->from($request->email);
                $mail->subject('Liên hệ');
            });
            $form_data = [
                'name' => $request->name,
                'phoneNumber' => $request->phoneNumber,
                'email' => $request->email,
                'conSubject' => $request->conSubject,
                'conMessage' => $request->conMessage,
            ];
            Contact::create($form_data);
            return response()->json(['success'=>'Gửi thư liên hệ thành công']);
        }
    }    
}
