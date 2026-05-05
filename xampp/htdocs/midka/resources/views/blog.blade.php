@extends('layouts.app')

@section('title', __('Новости'))

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
@endpush

@section('content')

<section id="blog" class="page active">
    <div class="container">
        <h2 class="section-title">{{ __('Карьерная аналитика') }}</h2>
        <div class="blog-grid">
            <div class="blog-card"><div class="chart-box"><canvas id="barChart"></canvas></div></div>
            <div class="blog-card"><div class="chart-box"><canvas id="lineChart"></canvas></div></div>
            <div class="blog-card"><div class="chart-box"><canvas id="pieChart"></canvas></div></div>
            <div class="blog-card"><div class="chart-box"><canvas id="polarChart"></canvas></div></div>
        </div>
    </div>
</section>

@endsection