<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Shared\NewsFeedBaseController;
use App\Models\Social\NewsFeed;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class NewsFeedMerchantController extends NewsFeedBaseController
{
    protected string $view = 'apps.merchant.news-feed.';
    protected string $route = 'merchant.news-feed.';

    private $auth;

    public function __construct()
    {
        parent::__construct();
        $this->auth = auth()->guard('merchant')->user();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Delete News Feed!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view($this->view . 'index', [
            'authUser' => $this->auth,
            'newsfeeds' => $this->newsFeeds,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->updateOrCreateNewsFeed($request);
        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $newsFeed = $this->findOrFailNewsFeed($id);
        $newsFeed->delete();
        Alert::success('Successfully Deleted!', 'News feed has been deleted!');
        return redirect()->back();
    }
}
