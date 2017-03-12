<?php
/**
 * Created by PhpStorm.
 * User: ky
 * Date: 12/03/2017
 * Time: 14:47
 */
?>
@extends('layouts.app')

@section('content')
@if($login_error = Session::has('login_error'))
    <div class="alert alert-info">
        {{$login_error}}
    </div>
@endif