<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Str;

use App\Category;

use App\Post;   

use Illuminate\Http\Request;

class PostController extends Controller
{

    protected $validation = [
        'title' => 'required|max:255',
        'content' => 'required',
        'category_id' => 'nullable|exsist:categories_id'
    ];

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
        $categories = Category::all();

        return view('admin.posts.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            "title"=>"required|string|max:80",
            "content"=>"required|string|max:255",
            "post_date"=>"required",
            "author"=>"required",
            "slug"=>"nullable",
            "category_id"=>"nullable"
        ]);

        $slugTmp = Str::slug($validated_data['title']);

        $count = 1;

        while(Post::where('slug',$slugTmp)->first()){
            $slugTmp = Str::slug($validated_data['title']).'-'.$count;
            $count ++;
        }

        $validated_data['slug'] = $slugTmp;

        $post = Post::create($validated_data);

        return redirect()->route('admin.posts.index', $post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();

        return view('admin.posts.edit', compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validated_data = $request->validate([
            "title"=>"required|string|max:80",
            "content"=>"required|string|max:255",
            "post_date"=>"required",
            "author"=>"required",
            "category_id"=>"nullable"
        ]);

        if($post->title == $validated_data['title']){
            $slug = $post->slug;
        }else{
            $slug = Str::slug($validated_data['title']);
            $count = 1;
            while(Post::where('slug',$slug)
                ->where('id','!=',$post->id)
                ->first()){
                    $slug = Str::slug($validated_data['title']).'-'.$count;
                    $count ++;
                }
            }
            
        $validated_data['slug'] = $slug; 

        $post->update($validated_data);
        
        return redirect()->route('admin.posts.index', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        
        return redirect()->route('admin.posts.index');

    }
}
