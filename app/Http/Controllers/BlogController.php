<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::orderBy('id', 'desc')->paginate(10);
        return view('employer.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employer.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:50', 'unique:blogs,title'],
            'image' => [
                'required',
                'max:1024',
                File::types(['png', 'jpg', 'jpeg'])
                    ->max('1mb')
            ],
            'content' => ['required', 'string']
        ]);

        $imageName = '';
        $imagepath = public_path('/blogs/');
        if ($image = $request->file('image')) {
            $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($imagepath, $imageName);
        }

        $blog = new Blog;
        $blog->fill($request->all());
        $blog->image = $imageName;
        $blog->created_by = Auth::guard('employer')->user()->id;
        $blog->save();

        return redirect()->route('blog_list')->with(['success' => true, 'message' => 'Blog has been created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $blog = Blog::select('id', 'title', 'content', 'image')->paginate(12);
        return view('blog', ['blogs' => $blog]);
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog, $id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return redirect()->route('blog_list')->with(['error' => true, 'message' => 'Blog not found.']);
        }
        return view('employer.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:50',  Rule::unique('blogs')->ignore($id)],
            'image' => [
                'max:1024',
                File::types(['png', 'jpg', 'jpeg'])
                    ->max('1mb')
            ],
            'content' => ['required', 'string']
        ]);

        $imageName = '';
        $imagepath = public_path('/blogs/');
        $blog = Blog::find($id);
        $blog->fill($request->all());
        if ($image = $request->file('image')) {
            $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($imagepath, $imageName);
            $blog->image = $imageName;
        }

        $blog->save();

        return redirect()->route('blog_list')->with(['success' => true, 'message' => 'Blog has been updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['error' => true, 'message' => 'Blog not found.']);
        }
        $blog->delete();

        return response()->json(['success' => true, 'message' => 'Blog has been deleted successfully.']);
    }

    /**
     * Blog details page.
     */
    public function blogDetails($id){
        $title = Str::headline($id);
        $blog = Blog::where('title', $title)->first();
        if (!$blog) {
            return redirect()->route('blog_list')->with(['error' => true, 'message' => 'Blog not found.']);
        }
        return view('blog-details', compact('blog'));
    }
}
