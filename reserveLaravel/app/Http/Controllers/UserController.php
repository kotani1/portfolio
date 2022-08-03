<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use PhpParser\Node\Expr\FuncCall;
use App\Http\Controllers\FormController;


class UserController extends Controller
{
    public function submit(Request $request)
    {
        session_start();
        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $password = $request->password;
        $password_conf = $request->password_conf;
        $err=[];

        if(empty($name)){
            $err['name'] = '名前を入力してください';
        }
        if(empty($phone)){
            $err['phone'] = '電話番号を入力してください';
        }
        if(empty($email)){
            $err['email'] = 'メールアドレスを入力してください';
        }
        if(empty($password)){
            $err['password'] = 'パスワードを入力してください';
        }
        if(empty($password_conf)){
            $err['password_conf'] = 'パスワード(確認用)を入力してください';
        }else if($password != $password_conf){
            $err['notEqual'] = 'パスワードが異なります';
        }
        if($item = User::where('email', $email)->value('email')){
            $err['isset'] = 'このメールアドレスは既に登録されています';
        }

        if(count($err)>0){
            return view('submit', compact('err'));
        }else{
            $user = new User();
            $password = password_hash($password, PASSWORD_DEFAULT);
            $model=$user->create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'password' => $password,
            ]);
            $_SESSION['name'] = $model->name;
            $_SESSION['id'] = $model->id;
            $_SESSION['msg'] = '登録完了しました';
            header('Location: /');
            exit();
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /');
        exit();
    }
    public function login(Request $request)
    {
        session_start();
        $err=[];
        $email = $request->email;
        $password = $request->password;

        if (empty($email)) {
            $err['email'] = 'メールアドレスを入力してください';
        }
        if (empty($password)) {
            $err['password'] = 'パスワードを入力してください';
        }
        if (count($err) > 0) {
            return view('login', compact('err'));
        }
        if($user = User::where('email', $email)->first()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['msg'] = 'ログイン成功しました';
                header('Location: /');
                exit();
            } else {
                $err['notPassword'] = "パスワードが違います";
            }
        }else{
            $err['notEmail'] = "メールアドレスが違います";
        }
        if (count($err) > 0) {
            return view('login', compact('err'));
        }

    }

}
