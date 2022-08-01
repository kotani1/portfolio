<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;
use Exception;
use Symfony\Component\HttpFoundation\RequestStack;
date_default_timezone_set('Asia/Tokyo');

class FormController extends Controller
{
    public $week = ['日', '月', '火', '水', '木', '金', '土'];
    public function index()
    {
        $name='';
        $date = '';
        $today = date('Y-m-d');
        $reserve = Reserve::where('date', '>', $today)->get();
        session_start();
        if (isset($_SESSION['id'])) {
            $name = $_SESSION['name'];
            if ($result = $reserve->where('userId', $_SESSION['id'])->first()) {
                $date = $result->date;
                $_SESSION['result'] = $result;
            }
        }
        return view('index', compact('date','name'));
    }
    public function form(Request $request)
    {
        $date = $request->date;  // $date = 'yyyy-mm-dd hh:ii'
        $ymd =  substr($date, 0, 10);
        $week = '(' . $this->week[date('w', strtotime($date))] . ')';
        $time = substr($date, 10);
        $dateView = $ymd . $week . $time;  //yyyy-mm-dd(曜日) hh:ii
        return view('/form', compact('dateView','date'));
    }
    public function check(Request $request)
    {
        $dateView = $request->dateView;
        $date = $request->date;
        $menu = $request->menu;
        return view('/formCheck', compact('dateView','date','menu'));
    }
    public function reserve(Request $request)
    {
        session_start();
        $menu = $request->menu;
        $date = $request->date;
        $dateView = $request->dateView;
        $reserve = new Reserve();
        try {
            $reserve->create([
                'userId' => $_SESSION['id'],
                'date' => $date,
                'menu' => $menu,
                'dateView' => $dateView,
            ]);
            $_SESSION['msg'] = '予約完了しました';
        } catch (Exception $e) {
            $_SESSION['msg'] = '他のユーザーが予約しています';
        }
        header('Location: /');
        exit();
    }
    public function json()
    {
        $today = date('Y-m-d');
        $reserve = Reserve::where('date', '>', $today)->get();
        $dates = $reserve->pluck('date');
        return view('json', compact('dates'));
    }
    public function info()
    {
        if (isset($_SESSION['result'])) {
            $info = $_SESSION['result'];
        } else {
            $info = '';
        }
        return view('info', compact('info'));
    }
    public function chancel()
    {
        session_start();
        Reserve::where('id', $_SESSION['result']->id)->delete();
        $_SESSION['msg'] = 'キャンセルしました';
        header('Location: /');
        exit();
    }
}
