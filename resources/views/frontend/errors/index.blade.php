@extends('frontend.template-' . $templateId . '.partials.master', ['title' => '404 Error'])


@section('content')
    @include('frontend.template-' . $templateId . '.breadcrumb.breadcrumb', [
        'slugName' => 'errors',
        'title' => '404 Error',
    ])
    @include('frontend.template-' . $templateId . '.404', [])
@endsection
