@extends('frontend.layouts.master')

@section('frontendtitle')
HomePage
@endsection
@section('frontend_content')
@include('frontend.pages.widgets.slider')
@include('frontend.pages.widgets.featured')
@include('frontend.pages.widgets.countdown')
@include('frontend.pages.widgets.best-sellar')
@include('frontend.pages.widgets.latest-product')
@include('frontend.pages.widgets.testimonial')
@endsection
