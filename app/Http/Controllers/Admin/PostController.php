<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Category;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'title' => 'required|max:255|unique:posts,title',
           'content' => 'required'
       ]);

       $dati = $request->all();

       $slug = Str::of($dati['title'])->slug('-');
       $original_slug = $slug;
       //verifico se lo slug esiste già nella tabella 'slug' nome colonna $slug valore
       $post_exists = Post::where('slug', $slug)->first(); //get = collection di oggetti, first = un oggetto
       // dd($post_exists);

       $contatore = 0;
       while($post_exists) {
           $contatore++;
           $slug = $original_slug . '-' . $contatore;
           $post_exists = Post::where('slug', $slug)->first();
       } //in questo modo lo slug sarà unico


       $dati['slug'] = $slug;
       //salvo i dati
       $nuovo_post = new Post();
       $nuovo_post->fill($dati);
       $nuovo_post->save();

       return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

       if($post) {
           return view('admin.posts.show', compact('post'));
       } else {
           return abort('404');
       }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        if($post) {
            return view('admin.posts.edit', compact('post'));
        } else {
            return abort('404');
        }
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
        $request->validate([
            'title' => 'required|max:255|unique:posts,title,'.$id,
            'content' => 'required'
        ]);

        $dati = $request->all();
        $slug = Str::of($dati['title'])->slug('-');
        $dati['slug'] = $slug;
        //verifico se lo slug esiste già nella tabella 'slug' nome colonna $slug valore
        $post_exists = Post::where('slug', $slug)->first(); //get = collection di oggetti, first = un oggetto
        // dd($post_exists);

        $contatore = 0;
        while($post_exists) {
            $contatore++;
            $slug = $original_slug . '-' . $contatore;
            $post_exists = Post::where('slug', $slug)->first();
        }
        //in questo modo lo slug sarà unico

        $dati['slug'] = $slug;

        $post = Post::find($id);
        $post->update($dati);

        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if($post) {

            $post->delete();
            return redirect()->route('admin.posts.index');

        } else {
            return abort('404');
        }
    }
}