<?php

namespace App\Controllers;
use App\Models\NewsModel;

class News extends BaseController
{
    public function index()
    {
        $model = new NewsModel();
        $data['news'] = $model->getNews();
        $data['title'] = 'News archive';

        return view('news/index', $data);
    }

    public function show($slug)
    {
        $model = new NewsModel();
        $data['news'] = $model->getNews($slug);

        if (empty($data['news'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item: ' . $slug);
        }

        $data['title'] = $data['news']['title'];

        return view('news/view', $data);
    }
}
