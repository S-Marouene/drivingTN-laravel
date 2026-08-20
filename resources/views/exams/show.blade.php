@extends('layout')
@section('content')
<div class="container py-4 exam-runner" data-question-count="{{ $exam->questions->count() }}" data-duration="{{ $questionDurationSeconds }}">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div><a href="{{ route('home') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Retour</a><h1 class="h3 fw-bold mt-2">{{ $exam->title }}</h1></div>
        <span class="badge text-bg-dark">Réussite à 24 / 30</span>
    </div>

    <form id="exam-form" method="POST" action="{{ route('exams.submit',$exam) }}">
        @csrf
        @foreach($exam->questions as $question)
            <input type="hidden" name="answers[{{ $question->id }}]" value="-1" data-answer="{{ $question->id }}">
            <article class="card question-step question-card mb-4" data-step="{{ $loop->index }}" @if(!$loop->first) style="display:none" @endif>
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-danger">Question <span class="current-number">{{ $question->position }}</span>/{{ $exam->questions->count() }}</span>
                        <span class="timer-badge badge text-bg-warning text-dark fs-6"><i class="bi bi-stopwatch"></i> <span class="seconds">{{ $questionDurationSeconds }}</span> s</span>
                    </div>
                    <div class="progress mb-4" style="height:9px"><div class="progress-bar bg-danger step-progress" style="width:{{ $question->position / $exam->questions->count() * 100 }}%"></div></div>
                    @if($question->audio_path)<div class="mb-3"><label class="form-label fw-semibold"><i class="bi bi-volume-up"></i> Écouter la question</label><audio controls class="w-100 question-audio" src="{{ str_starts_with($question->audio_path,'http') ? $question->audio_path : asset('storage/'.$question->audio_path) }}"></audio></div>@endif
                    @if($question->image_path)<div class="text-center mb-3"><img class="img-fluid rounded question-image" src="{{ str_starts_with($question->image_path,'http') ? $question->image_path : (str_starts_with($question->image_path,'images/') ? asset($question->image_path) : asset('storage/'.$question->image_path)) }}" alt="Illustration de la question"></div>@endif
                    <h2 class="h4 arabic mb-4">{{ $question->question_text }}</h2>
                    <div class="row g-3 arabic">
                        @foreach($question->options as $index=>$option)
                            <div class="col-md-4"><label class="option d-block"><input class="form-check-input me-2 answer-choice" type="radio" name="choice_{{ $question->id }}" value="{{ $index }}" data-question-id="{{ $question->id }}"><span>{{ $option }}</span></label></div>
                        @endforeach
                    </div>
                    <div class="text-center text-muted small mt-4"><i class="bi bi-info-circle"></i> Sélectionnez une réponse pour passer automatiquement à la question suivante.</div>
                </div>
            </article>
        @endforeach
        <div class="text-center pb-4"><button id="submit-exam" class="btn btn-primary btn-lg px-5" type="submit" style="display:none"><i class="bi bi-send"></i> Voir le résultat</button></div>
    </form>
</div>
@endsection
@section('scripts')
<script>
(() => {
    const runner = document.querySelector('.exam-runner');
    const steps = [...document.querySelectorAll('.question-step')];
    const form = document.getElementById('exam-form');
    const submit = document.getElementById('submit-exam');
    const duration = Number(runner.dataset.duration) || 20;
    let current = 0;
    let timer = null;
    let moving = false;

    function updateTimer(step, value) {
        step.querySelector('.seconds').textContent = value;
        step.querySelector('.timer-badge').classList.toggle('bg-danger', value <= 5);
        step.querySelector('.timer-badge').classList.toggle('bg-warning', value > 5);
    }

    function showStep(index) {
        steps.forEach((step, i) => step.style.display = i === index ? '' : 'none');
        current = index;
        if (timer) clearInterval(timer);
        const step = steps[current];
        let remaining = duration;
        updateTimer(step, remaining);
        timer = setInterval(() => {
            remaining -= 1;
            updateTimer(step, remaining);
            if (remaining <= 0) {
                clearInterval(timer);
                goNext();
            }
        }, 1000);
    }

    function goNext(value = null) {
        if (moving) return;
        moving = true;
        const step = steps[current];
        const selected = step.querySelector('.answer-choice:checked');
        const questionId = selected?.dataset.questionId || step.querySelector('.answer-choice')?.dataset.questionId;
        if (questionId && value !== null) document.querySelector(`[data-answer="${questionId}"]`).value = value;
        if (selected && value === null) document.querySelector(`[data-answer="${selected.dataset.questionId}"]`).value = selected.value;
        step.querySelectorAll('audio').forEach(audio => { audio.pause(); audio.currentTime = 0; });
        window.setTimeout(() => {
            if (current < steps.length - 1) {
                showStep(current + 1);
                moving = false;
            } else {
                clearInterval(timer);
                submit.style.display = '';
                form.submit();
            }
        }, value === null && !selected ? 250 : 180);
    }

    document.querySelectorAll('.answer-choice').forEach(choice => choice.addEventListener('change', () => goNext()));
    showStep(0);
})();
</script>
@endsection
