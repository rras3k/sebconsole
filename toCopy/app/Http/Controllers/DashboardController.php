<?php

namespace App\Http\Controllers;

use Rras3k\Sebconsole\Http\Controllers\SbController;


class DashboardController extends SbController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $data=[];
        $this->page_setTitre('Dashoard');
        $data['rras3k'] = $this->dataToView();

        return view('dashboard-show', compact('data'));

    }
    public function getPara(){}

}
