<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;

class ArticaleController extends Controller implements HasMiddleware {

    public static function middleware() {
        return [
            new Middleware(middleware: "permission:view article", only: ['index']),
            new Middleware(middleware: "permission:create article", only: ['create']),
            new Middleware(middleware: "permission:edit article", only: ['edit']),
            new Middleware(middleware: "permission:delete article", only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $articles = Article::orderBy("created_at", "desc")->paginate(10);
        return view('articles.list', ["articles" => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //

        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //

        $validator = Validator::make($request->all(), [
            "title" => "required|min:5",
            "author" => "required",
        ]);

        if ($validator->passes()) {
            Article::create([
                "title" => $request->title,
                "author" => $request->author,
                "text" => $request->text,
            ]);
            return redirect()->route('articles.create')->with('success', 'Article created successfully');
        } else {
            return redirect()->route('articles.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        //

        return view('articles.show', ["article" => Article::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        //

        return view('articles.edit', ["article" => Article::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        //

        $validator = Validator::make($request->all(), [
            "title" => "required|min:5",
            "author" => "required",
        ]);

        if ($validator->passes()) {
            $article = Article::find($id);
            $article->update([
                "title" => $request->title,
                "author" => $request->author,
                "text" => $request->text,
            ]);
            return redirect()->route('articles.index', ["id" => $id])->with('success', 'Article updated successfully');
        } else {
            return redirect()->route('articles.edit', ["id" => $id])->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {

        $article = Article::find($id);
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully');
    }
}
