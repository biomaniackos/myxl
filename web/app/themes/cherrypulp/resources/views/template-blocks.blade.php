{{--
  Template Name: Blocks Template
--}}

@php
    $header_no_bg = true;
    $main_background = true;
@endphp

@extends('layouts.app')

@php
$hero = get_field('hero');
$composer = get_field('composer');
@endphp

@section('content')
@include('components.widgets-hero', ['is_front' => false])
@include('components.composer')
@endsection