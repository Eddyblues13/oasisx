@extends('errors.layout')

@section('title', '401 Unauthorized')
@section('code', '401')
@section('heading', 'Unauthorized')
@section('message', 'You need to be authenticated to access this page. Please log in and try again.')