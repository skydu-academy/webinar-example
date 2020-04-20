<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirstController extends Controller
{
    //
    public function get()
    {
        return "<h1>First controller @ function get()</h1>";
    }

    public function post()
    {
        return "<h1>First controller @ function post()</h1>";
    }

    public function put()
    {
        return "<h1>First controller @ function put()</h1>";
    }

    public function delete()
    {
        return "<h1>First controller @ function delete()</h1>";
    }
}
