<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

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
        $posts = Post::orderBy('id', 'desc')->get();

        return view('home', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.create');
    }

    /**
     * Resize image.
     *
     * @param $file_input
     * @param $file_output
     * @param $w_o
     * @param $h_o
     * @param bool $percent
     * @return bool|void
     */
    public function imgResize($file_input, $file_output, $w_o, $h_o, $percent = false) {
        list($w_i, $h_i, $type) = getimagesize($file_input);
        if (!$w_i || !$h_i) {
            echo 'Undefined width or high!';
            return;
        }
        $types = array('','gif','jpeg','png', 'jpg');
        $ext = $types[$type];
        if ($ext) {
            $func = 'imagecreatefrom'.$ext;
            $img = $func($file_input);
        } else {
            echo 'File type error!';
            return;
        }
        if ($percent) {
            $w_o *= $w_i / 100;
            $h_o *= $h_i / 100;
        }
        if (!$h_o) $h_o = $w_o/($w_i/$h_i);
        if (!$w_o) $w_o = $h_o/($h_i/$w_i);

        $img_o = imagecreatetruecolor($w_o, $h_o);
        imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
        if ($type == 2) {
            return imagejpeg($img_o,$file_output,100);
        } else {
            $func = 'image'.$ext;
            return $func($img_o,$file_output);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'slug' => 'required|unique:post',
            'name' => 'required'
        ]);

        if($request->hasFile('preview')) {
            $all = $request->all();
            $date = date('d.m.Y');
            $root = $_SERVER['DOCUMENT_ROOT']."/public/img/";
            if(!file_exists($root.$date)) {
                mkdir($root.$date);
            }
            $f_name = $request->file('preview')->getClientOriginalName();
            $request->file('preview')->move($root.$date, $f_name);
            $all['preview'] = "/public/img/".$date."/".$f_name;

            Post::create($all);
            $this->imgResize($_SERVER['DOCUMENT_ROOT'].$all['preview'], $_SERVER['DOCUMENT_ROOT'].$all['preview'], 100, 0);
        } else {
            Post::create($request->all());
        }
        $request->flash();

        return redirect('home')->with('message', 'Post added.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $posts = Post::find($id);

        return view('back.edit', ['posts' => $posts]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $posts = Post::find($id);

        if($request->hasFile('preview')) {
            $all = $request->all();

            $date = date('d.m.Y');
            $root = $_SERVER['DOCUMENT_ROOT']."/public/img/";
            if(!file_exists($root.$date)) {
                mkdir($root.$date);
            }
            $f_name = $request->file('preview')->getClientOriginalName();
            $request->file('preview')->move($root.$date, $f_name);
            $all['preview'] = "/public/img/".$date."/".$f_name;

            $posts->update($all);
            $this->imgResize($_SERVER['DOCUMENT_ROOT'].$all['preview'], $_SERVER['DOCUMENT_ROOT'].$all['preview'], 100, 0);
        } else {
            $posts->update($request->all());
        }
        return redirect('home')->with('message', 'Post updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Post::find($id);
        $posts->delete();
        $root = $_SERVER['DOCUMENT_ROOT'];
        if(!empty($posts->preview)) {
            unlink($root.$posts->preview);
        }
        return back()->with('message', 'Post deleted.');
    }
}
