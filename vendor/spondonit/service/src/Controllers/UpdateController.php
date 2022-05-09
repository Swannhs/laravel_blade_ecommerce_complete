<?php

namespace SpondonIt\Service\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SpondonIt\Service\Repositories\InitRepository;
use SpondonIt\Service\Repositories\UpdateRepository;

class UpdateController extends Controller
{
    protected $request;
    protected $repo;
    protected $init;

    public function __construct(
        Request $request,
        UpdateRepository $repo,
        InitRepository $init
    ) {
        $this->request = $request;
        $this->repo = $repo;
        $this->init = $init;
    }

    public function index()
    {
        $preRequisite = $this->init->product();
        return view('service::update.index', $preRequisite);
    }

    public function download()
    {
        $release = $this->repo->download();
        return response()->json(['message' => trans('service::install.updated'), 'goto' => route('service.update')]);
    }

    public function update()
    {
        $this->repo->update($this->request->all());
        return response()->json(['message' => trans('service::install.updated'), 'goto' => route('service.update')]);
    }
}
