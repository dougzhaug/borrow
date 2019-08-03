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
     * 美图录
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        set_time_limit (0);
        $client = new Client();

        $crawler = $client->request('GET', 'https://www.meitulu.com/item/18512.html');
        //名称
        print $crawler->filter('.weizhi > h1')->text();

        //描述
        $crawler->filter('.c_l > p')->each(function ($node) {
            print $node->text()."\n";
        });

        //标签
        $crawler->filter('.fenxiang_l > a')->each(function ($node) {
            print $node->text()."\n";
        });

        //图片地址
        for($i=1;$i<=100;$i++){
            sleep(rand(3,10));
            $res = $this->curl('https://mtl.ttsqgs.com/images/img/18512/'.$i.'.jpg','https://www.meitulu.com','d:/img/'.$i.'.jpg');
            if(!$res){
                break;
            }
        }

        dd($crawler);die;
        return view('home');
    }

    function curl($url, $referer, $download=false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 500);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/600.1.3 (KHTML, like Gecko) Version/8.0 Mobile/12A4345d Safari/600.1.4'));
        curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, -1);
        $contents = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($httpCode != 200){
            return false;
        }
        curl_close($ch);
        if ($download) {
            $resource = fopen($download, 'w');
            fwrite($resource, $contents);
            fclose($resource);
            return $download;
        }
        return $contents;
    }

    /**
     * 妹子图
     */
    public function mzitu()
    {
        set_time_limit (0);
        $client = new Client();

        $crawler = $client->request('GET', 'https://www.mzitu.com/189321');

        //标题
        print $crawler->filter('.main-title')->text();

        $crawler->filter('.main-meta > span')->each(function ($node,$k) {
            //分类
            if($k == 0){
                print $node->filter('a')->text();
            }
            //发布时间
            if($k == 1){
                print explode(' ',$node->text())[1];
            }
        });

        //标签
        $crawler->filter('.main-tags > a')->each(function ($node,$k) {
            print $node->text().'<br/>';
        });

        for ($i=1;$i<=100;$i++){
            sleep(rand(3,10));
            $crawler = $client->request('GET', 'https://www.mzitu.com/189321/'.$i);
            $title = $crawler->filter('title')->text();
            if(strpos($title,'404') !== false){
                break;
            }

            $img_url = $crawler->filter('div.main-image > p > a > img')->attr('src');
            $res = $this->curl($img_url,'https://www.mzitu.com','d:/img/'.$i.'.jpg');
            if(!$res){
                break;
            }
        }

        dd($crawler);die;
    }
}
