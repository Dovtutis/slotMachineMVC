<?php

class Pages extends Controller
{
    public function __construct(){

    }

    public function index()
    {
        $data = [
            'title' => 'Welcome to ' . SITENANE,
            'description' => 'This is a slot machine game'
        ];
        $this->view('pages/index', $data);
    }
}