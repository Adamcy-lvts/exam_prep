<x-filament-panels::page>
{{-- In your Filament view file --}}

<x-result-page-component 
    :questions="$questions" 
    :total-score="$totalScore"
    :total-marks="$totalMarks"
    :formatted-time-spent="$formattedTimeSpent"
    :answered-correct-questions="$answeredCorrectQuestions"
    :answered-wrong-questions="$answeredWrongQuestions"
    :unanswered-questions="$unansweredQuestions"
    :quizzable="$quizzable"
    :remaining-attempts="$remainingAttempts"
    :organized-performances="$organizedPerformances" 
    :test-answers="$testAnswers"
/>

</x-filament-panels::page>
