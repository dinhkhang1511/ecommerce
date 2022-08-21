<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Blog;
use App\Http\Requests\BlogStoreRequest;
use App\Http\Requests\BlogUpdateRequest;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class BlogController extends Controller
{
    public function index()
    {
        $data = GetData()->getDataWithParam('blogs',request()->all());
        if(!isset($data->blogs))
            abort(404);
        return view('backend.blog.index', compact('data'));
    }

    public function create()
    {
        // $tags = Tag::all();
        $data = GetData()->getDataWithParam('tags',['limit' => 'all']);
        $tags = $data->tags ?? [];
        return view('backend.blog.create', compact('tags'));
    }

    public function store(BlogStoreRequest $request)
    {
        $headers = ['access_token' => Cookie::get('access_token')];
        $data = $request->validated();
        $options = [
            'multipart' => [
              [
                'name' => 'title',
                'contents' => $data['title']
              ],
              [
                'name' => 'body',
                'contents' => $data['body']
              ],
              [
                'name' => 'image_path',
                'contents' => file_get_contents($request->file('image_path')->getRealPath(), 'r'),
                'filename' => 'temp.jpg',
                'headers'  => [
                'Content-Type' => '<Content-type header>'
                ]
              ],
            ]
        ];
        foreach ($data['tags'] as $key => $value) {
            $options['multipart'][] = [
                    'name' => 'tags[]',
                    'contents' => $data['tags'][$key]
            ];
        }

        $response = HttpService()->postDataWithOptions('blogs', $options, $headers);


        // $blog = Blog::create($request->validated());
        // $blog->tags()->attach($request->tags);
        // return success('blogs.index');
        if($response->status == 402)
            return back()->with('errors', $response->errors);

        return success('blogs.index');
    }

    public function edit($id)
    {
        $data = GetData()->getDataWithParam('tags',['limit' => 'all']);
        $tags = $data->tags ?? [];

        $data = GetData()->getDataFromId('blogs',$id);
        $blog = $data->blogs ?? [];

        return view('backend.blog.edit', compact('blog', 'tags'));
    }

    public function update(BlogUpdateRequest $request, $id)
    {
        $headers = ['access_token' => Cookie::get('access_token')];
        $data = $request->validated();
        $options = [
            'multipart' => [
              [
                'name' => 'title',
                'contents' => $data['title']
              ],
              [
                'name' => 'body',
                'contents' => $data['body']
              ],
            ]
        ];
        if($request->hasFile('image_path'))
        {
            $options['multipart'][] = [
                'name' => 'image_path',
                'contents' => file_get_contents($request->file('image_path')->getRealPath(), 'r'),
                'filename' => 'temp.jpg',
                'headers'  => [
                'Content-Type' => '<Content-type header>'
                ]
            ];
        }

        foreach ($data['tags'] as $key => $value) {
            $options['multipart'][] = [
                    'name' => 'tags[]',
                    'contents' => $data['tags'][$key]
            ];
        }

        $response = HttpService()->updateDataWithOptions('blogs',$id, $options, $headers);

        if($response->status == 402)
            return back()->with('errors', $response->errors);

        return success('blogs.index');
    }

    public function destroy($id)
    {
        $headers = ['access_token' => Cookie::get('access_token')];
        $resposne = HttpService()->deletedData('blogs', $id, [], $headers);

        return success('blogs.index');
    }
}
