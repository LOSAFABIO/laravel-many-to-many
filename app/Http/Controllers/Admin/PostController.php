<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Str;

use App\Tag;

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
        $tags = Tag::all();   

        return view('admin.posts.index', compact('posts', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create',compact('categories','tags'));
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
            "category_id"=>"nullable",
            "tag_id"=>"nullable"
        ]);

        $validated_data = $request->all();

        $slugTmp = Str::slug($validated_data['title']);

        $count = 1;

        while(Post::where('slug',$slugTmp)->first()){
            $slugTmp = Str::slug($validated_data['title']).'-'.$count;
            $count ++;
        }

        $validated_data['slug'] = $slugTmp;

        $post = Post::create($validated_data);

        $post->tags()->sync($validated_data['tags']);

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
        $tags = Tag::all();

        return view('admin.posts.edit', compact('post','categories','tags'));
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
            "category_id"=>"nullable",
            "tag_id"=>"nullable"
        ]);

        $validated_data = $request->all();

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

        $post->tags()->sync(isset($validated_data['tags'])?$validated_data['tags']:[]);
        
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
