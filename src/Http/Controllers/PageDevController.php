<?php

namespace Rras3k\Sebconsole\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Rras3k\SebconsoleRoot\facades\Core;


class PageDevController extends Controller
{
    public function getPara()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Core::init();

        View::addNamespace('sebconsoleviews', 'Rras3k/SebconsoleRoot/ressources/views');

        $data = array();

        $data['pages'] = $this->getListePagesPasgit();
        // $data['pages'] = [ 'page-1','page-2'];


        return view('sebconsoleviews::page-dev', compact('data'));

    }
    private function getListePagesPasgit(){
        $ret = [];
        $path = resource_path('views/page-dev');

        $files = scandir($path);
        foreach ($files as $key => $value) {
            if (strlen($value)>10 && ($ind=stripos($value,'.blade.php'))!==false)    {
                $ret[] = substr($value,0, $ind);
            }
        }


        return $ret;

    }

    public function getPage($nomPage){
        // dd($nomPage);
        return view('page-dev.'.$nomPage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Formule  $formule
     * @return \Illuminate\Http\Response
     */
    public function show(Formule $formule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Formule  $formule
     * @return \Illuminate\Http\Response
     */
    public function edit(Formule $formule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Formule  $formule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Formule $formule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Formule  $formule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Formule $formule)
    {
        //
    }
}
