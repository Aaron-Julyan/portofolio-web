<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use robertogallea\LaravelPython\Services\LaravelPython;

class PythonController extends Controller
{
    public function index()
    {
        // HAPUS AJA CONTROLLER NYA, GA BISA DIPAKE
        $pathToScript = "D:/PETRA/Semester 8 - Skripsi/laravel_apps/porotofolioWeb/public/storage/sintascraper/sinta-scraper-main/setup.py";
        $service = new LaravelPython();
        $result = $service->run($pathToScript);
        $parameters = array('6082456');
        $result = $service->run($pathToScript, $parameters);
        dd($result);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
