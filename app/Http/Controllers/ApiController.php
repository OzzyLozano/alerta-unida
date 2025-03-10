<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller {
  public function index() {
    return 'este es un index en ApiController';
  }
  public function show(string $value) {
    return $value;
  }
}
