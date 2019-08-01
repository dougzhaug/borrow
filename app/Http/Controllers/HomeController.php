<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = new Client();
        //https://www.meitulu.com/item/18512_2.html
        //https://www.meitulu.com/item/18512_5.html
        $crawler = $client->request('GET', 'https://www.meitulu.com/item/18512.html');
        //名称
        print $crawler->filter('.weizhi > h1')->text();

        //描述
        $crawler->filter('.c_l > p')->each(function ($node) {
            print $node->text()."\n";
        });

        //图片地址
        $crawler->filter('.content > center > img')->each(function ($node) {
            print $node->attr('src')."\n";
        });

        //标签
        $crawler->filter('.fenxiang_l > a')->each(function ($node) {
            print $node->text()."\n";
        });
        dd($crawler);die;
        return view('home');
    }
}
