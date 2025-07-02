@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Analytics Dashboard</h2>

    <div class="row">
        <!-- Sentiment Overview -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Sentiment Analysis Overview</h5>
                </div>
                <div class="card-body">
                    <canvas id="sentimentChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Trending Topics -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Trending Topics</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($analytics['trending_topics'] as $topic)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $topic->topic_classification }}
                                <span class="badge bg-primary rounded-pill">{{ $topic->count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Popular Keywords -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Popular Keywords</h5>
                </div>
                <div class="card-body">
                    <div id="keywordCloud"></div>
                </div>
            </div>
        </div>

        <!-- Engagement Metrics -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Engagement Metrics</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Average Engagement Score
                            <span class="badge bg-primary rounded-pill">{{ number_format($analytics['engagement_metrics']->avg_engagement, 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Average Reading Time
                            <span class="badge bg-info rounded-pill">{{ floor($analytics['engagement_metrics']->avg_reading_time / 60) }} min</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Average Popularity Score
                            <span class="badge bg-success rounded-pill">{{ number_format($analytics['engagement_metrics']->avg_popularity, 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Average CTR
                            <span class="badge bg-warning rounded-pill">{{ number_format($analytics['engagement_metrics']->avg_ctr, 2) }}%</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Average Bounce Rate
                            <span class="badge bg-danger rounded-pill">{{ number_format($analytics['engagement_metrics']->avg_bounce_rate, 2) }}%</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/d3@7"></script>
<script src="https://cdn.jsdelivr.net/npm/d3-cloud@1.2.5/build/d3.layout.cloud.min.js"></script>

<script>
// Sentiment Chart
const sentimentCtx = document.getElementById('sentimentChart').getContext('2d');
new Chart(sentimentCtx, {
    type: 'doughnut',
    data: {
        labels: ['Positive', 'Neutral', 'Negative'],
        datasets: [{
            data: [
                {{ $analytics['sentiment_overview']->positive }},
                {{ $analytics['sentiment_overview']->neutral }},
                {{ $analytics['sentiment_overview']->negative }}
            ],
            backgroundColor: ['#28a745', '#ffc107', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Word Cloud
const keywords = @json($analytics['popular_keywords']);
const words = Object.entries(keywords).map(([text, value]) => ({ text, value }));

const width = document.getElementById('keywordCloud').offsetWidth;
const height = 300;

const layout = d3.layout.cloud()
    .size([width, height])
    .words(words)
    .padding(5)
    .rotate(() => 0)
    .fontSize(d => Math.sqrt(d.value) * 10)
    .on('end', draw);

layout.start();

function draw(words) {
    d3.select('#keywordCloud').append('svg')
        .attr('width', width)
        .attr('height', height)
        .append('g')
        .attr('transform', `translate(${width/2},${height/2})`)
        .selectAll('text')
        .data(words)
        .enter().append('text')
        .style('font-size', d => `${d.size}px`)
        .style('fill', () => `hsl(${Math.random() * 360}, 70%, 50%)`)
        .attr('text-anchor', 'middle')
        .attr('transform', d => `translate(${d.x},${d.y})rotate(${d.rotate})`)
        .text(d => d.text);
}
</script>
@endpush
@endsection 