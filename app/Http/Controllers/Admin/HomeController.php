<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Page;
use App\Dashboard;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {

        $users = 0;
        $pages = 0;
        $usersOnline = 0;
        $access = 0;

        $users = User::count();
        $pages = Page::count();
        $access = Dashboard::count();

        $dateLimit = date('Y-m-d H:i:s', strtotime('-5minutes'));

        $dateAcessOnline = Dashboard::select('ip')->where('dateAccess', '>=', $dateLimit)
            ->groupBy('ip')
            ->get(); 
        
        $userOnline = count($dateAcessOnline);

        $pageAllVisits = Dashboard::selectRaw('page, count(page) as p')
            ->groupBy('page')
            ->get();

        $pagePie = [];
        foreach($pageAllVisits as $visit) {
           $pagePie[ $visit['page'] ] = intval($visit['p']);
           
        }

        $pageLabels = json_encode(array_keys($pagePie));
        $pageValues = json_encode(array_values($pagePie));

        return view('admin.home', compact('users', 'pages',
         'access', 'userOnline',
        'pageLabels', 'pageValues'));
    }
}
