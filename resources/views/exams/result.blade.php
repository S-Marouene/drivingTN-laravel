@extends('layout')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center"><div class="col-lg-8">
        <div class="card text-center mb-4"><div class="card-body p-5"><div class="display-1 mb-3">{{ $attempt->passed ? '✓' : '!' }}</div><span class="badge {{ $attempt->passed ? 'text-bg-success' : 'text-bg-danger' }} fs-6 mb-3">{{ $attempt->passed ? 'Examen réussi' : 'Examen non réussi' }}</span><h1 class="fw-bold">{{ $attempt->score }} / {{ $attempt->total_questions }}</h1><p class="lead">{{ $attempt->passed ? 'Félicitations, vous avez atteint le seuil requis de 24 bonnes réponses.' : 'Il faut obtenir au moins 24 bonnes réponses. Continuez à vous entraîner.' }}</p><div class="progress my-4"><div class="progress-bar {{ $attempt->passed ? 'bg-success' : 'bg-danger' }}" style="width:{{ $attempt->score/30*100 }}%"></div></div><div class="d-flex justify-content-center gap-2"><a href="{{ route('exams.show',$attempt->exam) }}" class="btn btn-primary">Recommencer</a><a href="{{ route('home') }}" class="btn btn-outline-secondary">Retour à l’accueil</a></div></div></div>

        @if($wrongQuestions->isNotEmpty())
            <div class="d-flex justify-content-between align-items-center mb-3"><div><h2 class="h4 fw-bold mb-1">Correction de vos erreurs</h2><p class="text-muted mb-0">Seules les réponses incorrectes sont affichées.</p></div><span class="badge text-bg-danger">{{ $wrongQuestions->count() }} erreur(s)</span></div>
            @foreach($wrongQuestions as $question)
                @php($selected = (int) ($attempt->answers[$question->id] ?? -1))
                <article class="card mb-3 border-start border-danger border-4"><div class="card-body p-4"><div class="d-flex justify-content-between align-items-center mb-3"><span class="badge text-bg-secondary">Question {{ $question->position }}</span><span class="badge text-bg-danger">Incorrecte</span></div><h3 class="h5 arabic mb-4">{{ $question->question_text }}</h3><div class="alert alert-danger mb-2"><strong><i class="bi bi-x-circle"></i> Votre réponse :</strong><span class="arabic d-block">{{ $selected >= 0 ? ($question->options[$selected] ?? 'Réponse inconnue') : 'لم تتم الإجابة في الوقت المحدد' }}</span></div><div class="alert alert-success mb-0"><strong><i class="bi bi-check-circle"></i> Bonne réponse :</strong><span class="arabic d-block">{{ $question->options[$question->correct_option] }}</span></div></div></article>
            @endforeach
        @else
            <div class="alert alert-success text-center"><i class="bi bi-check-circle-fill"></i> Excellent : aucune réponse incorrecte.</div>
        @endif
    </div></div>
</div>
@endsection
