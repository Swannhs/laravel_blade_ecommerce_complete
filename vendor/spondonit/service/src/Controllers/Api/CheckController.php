<?php

namespace SpondonIt\Service\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SpondonIt\Service\Repositories\InitRepository;

class CheckController extends Controller{

	private $initRepo, $request;

	public function __construct(InitRepository $initRepo, Request $request){
		$this->initRepo = $initRepo;
		$this->request = $request;
	}

	public function index(){
		if(!$this->request->wantsJson()){
			return 'invalid api call';
		}

		return response()->json($this->initRepo->apiCheck());
	}
}