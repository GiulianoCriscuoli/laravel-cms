<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Page;
use PDOException;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::paginate(10);

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'title',
            'body'
        ]);

        
        $data['slug'] = Str::slug($data['title'], '-');

        $validator = $this->validator($data);

        if($validator->fails()) {

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();

        } else {
            
            try {

                $page = new Page();
                $page->title = $data['title'];
                $page->body = $data['body'];
                $page->slug = $data['slug'];
                $page->save();

                return redirect()
                    ->route('pages.index')
                    ->with('success', 'Página criada com sucesso');

            } catch(PDOException $e) {

                return 'Não foi possível salvar a página: '.$e->getMessage();
            }     
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::find($id);

        if($page) {

            return view('admin.pages.edit', compact('page'));

        } else {

            return redirect()->route('pages.index');
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

        $page = Page::find($id);

        if ($page) {

            $data = $request->only([
                'title',
                'body'
            ]);

            if(!empty($page->title)) {
                
                $data['slug']  = Str::slug($data['title'], '-');
            }


            if ($page->title !== $data['title']) {

                Validator::make($data, [
                    'title' => ['required', 'string', 'max:100'],
                    'body' => ['string']
                ]);

                $page = new Page();
                $page->title = $data['title'];
                $page->body = $data['body'];
                $page->slug = $data['slug'];
                $page->save();

                return redirect()
                    ->route('pages.index')
                    ->with('success', 'Página editada com sucesso!');

            } else {

                $validator = $this->validator($data);

                if($validator->fails()) {

                    return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();

                } else {
                 
                    $page->update($data);

                    return redirect()
                        ->route('pages.index')
                        ->with('success', 'Página editada com sucesso!');
                } 
            }

        } else {

            return redirect()->back();
        }       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::find($id);

        if($page) {

            $page->delete();

            return redirect()->back();
        }
    }

    protected function validator(array $data) {

        return Validator::make($data, [
            'title' => ['required', 'string', 'max:100'],
            'body' => ['string'],
            'slug' => ['string', 'unique:pages']
        ]);
    }
}
