<?php

namespace App\Http\Controllers;

use App\Models\Data;
use DOMDocument;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Global_;

class DataController extends Controller
{
    // public function index()
    // {
    //     $scraped = Data::simplePaginate(15);
    //     return view('welcome', ['scraped' => $scraped]);
    // }

    public function loaddata()
    {
        ini_set("max_execution_time", 90000);
        $ch = curl_init();
        $nextPageExists = true;
        $pageNum = 1;
        $a = $x = 0;
        do {
            $url = "https://news.ycombinator.com/?p=$pageNum";

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $html = curl_exec($ch);

            $DOM = new DOMDocument;
            libxml_use_internal_errors(true);
            echo $url . "</br>";
            $DOM->loadHTML($html);

            $elements = $DOM->getElementsByTagName('tr');
            //  $element = $DOM->getElementsByTagName('span');
            $title = $url = $uname = $points = $comments = false;

            for ($i = 0; $i < $elements->length; $i++) {
                $class = $elements[$i]->getAttribute('class');
                if ($class == 'athing') {
                    $spans = $elements[$i]->getElementsByTagName('span');
                    foreach ($spans as $span) {

                        $spanClass = $span->getAttribute('class');
                        if ($spanClass == 'titleline') {
                            $aTags = $span->getElementsByTagName('a');
                            $url = $aTags[0]->getAttribute('href');
                            $title = $aTags[0]->nodeValue;
                        }
                    }
                    $a = $x;
                    if (!empty($title)) {
                        $array[$a]["title"] = $title;
                        $array[$a]["url"] = $url;
                        $data = new Data;
                        $data->title = $title;
                        $data->url = $url;
                    }
                }
                if ($class != 'spacer' && $class != 'athing') {
                    $a = $a;
                    $spans = $elements[$i]->getElementsByTagName('span');
                    foreach ($spans as $span) {

                        $spanClass = $span->getAttribute('class');
                        if ($spanClass == 'score') {
                            $points = $span->nodeValue;
                        }
                    }
                    $aTags = $elements[$i]->getElementsByTagName('a');
                    foreach ($aTags as $tag) {
                        $aTagClass = $tag->getAttribute('class');
                        if ($aTagClass == 'hnuser') {
                            $user = $tag->nodeValue;
                        }
                    }

                    $anchor = $elements[$i]->getElementsByTagName('a');
                    foreach ($anchor as $tag) {
                        $comments = $tag->nodeValue;
                    }

                    if (!empty($points) && isset($array[$a])) {
                        $array[$a]["points"] = $points;
                        $data->points = $points;
                    }

                    if (!empty($user) && isset($array[$a])) {
                        $array[$a]["user"] = $user;
                        $data->username = $user;
                    }
                    if (!empty($comments) && isset($array[$a])) {
                        $array[$a]["comments"] = $comments;
                        $data->comments = $comments;
                        //$data->save();
                    }
                }

                $x++;
                $min = 5;
                $max = 10;
                $random_sleep = rand($min, $max);
                sleep($random_sleep);
            }
            if (strpos($html, 'morelink') !== false) {
                $nextPageExists = true;
                $pageNum++;
            } else {
                $nextPageExists = false;
            }
        } while ($nextPageExists);
        dd($array);
        curl_close($ch);
    }

    // public function refreshdata()
    // {
    //     Data::truncate();
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, 'https://news.ycombinator.com/');
    //     curl_setopt($ch, CURLOPT_POST, false);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //     $html = curl_exec($ch);
    //     curl_close($ch);

    //     $DOM = new DOMDocument;
    //     libxml_use_internal_errors(true);
    //     $DOM->loadHTML($html);
    //     $elements = $DOM->getElementsByTagName('tr');
    //     $element = $DOM->getElementsByTagName('span');
    //     $title = $url = $uname = $points = $comments = false;
    //     $a = 0;
    //     for ($i = 0; $i < $elements->length; $i++) {
    //         $class = $elements[$i]->getAttribute('class');
    //         if ($class == 'athing') {
    //             $spans = $elements[$i]->getElementsByTagName('span');
    //             foreach ($spans as $span) {

    //                 $spanClass = $span->getAttribute('class');
    //                 if ($spanClass == 'titleline') {
    //                     $aTags = $span->getElementsByTagName('a');
    //                     $url = $aTags[0]->getAttribute('href');
    //                     $title = $aTags[0]->nodeValue;
    //                 }
    //             }
    //             $a = $i;
    //             if (!empty($title)) {
    //                 $array[$a]["title"] = $title;
    //                 $array[$a]["url"] = $url;
    //                 $data = new Data;
    //                 $data->title = $title;
    //                 $data->url = $url;
    //             }
    //         }
    //         if ($class != 'spacer' && $class != 'athing') {
    //             $a = $a;
    //             $spans = $elements[$i]->getElementsByTagName('span');
    //             foreach ($spans as $span) {

    //                 $spanClass = $span->getAttribute('class');
    //                 if ($spanClass == 'score') {
    //                     $points = $span->nodeValue;
    //                 }
    //             }
    //             $aTags = $elements[$i]->getElementsByTagName('a');
    //             foreach ($aTags as $tag) {
    //                 $aTagClass = $tag->getAttribute('class');
    //                 if ($aTagClass == 'hnuser') {
    //                     $user = $tag->nodeValue;
    //                 }
    //             }
    //             $anchor = $elements[$i]->getElementsByTagName('a');
    //             foreach ($anchor as $tag) {
    //                 $comments = $tag->nodeValue;
    //             }

    //             if (!empty($points) && isset($array[$a])) {
    //                 $array[$a]["points"] = $points;
    //                 $data->points = $points;
    //             }

    //             if (!empty($user) && isset($array[$a])) {
    //                 $array[$a]["user"] = $user;
    //                 $data->username = $user;
    //             }
    //             if (!empty($comments) && isset($array[$a])) {
    //                 $array[$a]["comments"] = $comments;
    //                 $data->comments = $comments;
    //                 $data->save();
    //             }
    //         }
    //     }
    //     return redirect(route('index'));
    // }

    // public function destroy($id)
    // {
    //     Data::destroy($id);
    //     $scraped = Data::simplePaginate(15);
    //     return redirect(route('index'));
    // }


}
