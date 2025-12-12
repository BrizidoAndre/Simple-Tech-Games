<?php
/**
 * @var string $month
 */
$dateMonth = DateTimeImmutable::createFromFormat('d-M-Y', '01-' . $month);
if (!$dateMonth) {
    $dateMonth = new DateTimeImmutable('first day of this month');
}
$today = new DateTimeImmutable('today');
// navigation
$prevMonth = $dateMonth->modify('-1 month');
$nextMonth = $dateMonth->modify('+1 month');
// getting the first and last day of this month
$firstDayOfCurrentMonth = $dateMonth->modify('first day of this month');
$lastDayOfCurrentMonth = $dateMonth->modify('last day of this month');
// starting the array for dates
$dates = [];
// copy the first day of the month to be added
$firstDayCalendar = $firstDayOfCurrentMonth->modify('+24 hours -1 day');
$dates[] = $firstDayCalendar;
// while the day is not the first of the week
// keep going back
while ($firstDayCalendar->format('w') != 0) {
//    get the immediate day before
    $firstDayCalendar = $firstDayCalendar->modify('-1 day');
    $dates[] = $firstDayCalendar;
}
// get the immediate day after the first
$currentDay = $firstDayOfCurrentMonth->modify('+1 day');
// start the loop to add the days of this current month
// while the date is not the same as the last day it means we're still on the first day
while ($currentDay->getTimestamp() !== $lastDayOfCurrentMonth->getTimestamp()) {
    $dates[] = $currentDay;
    $currentDay = $currentDay->modify('+1 day');
}
// copy the last day of current month
$lastDayCalendar = $lastDayOfCurrentMonth->modify('+24 hours -1 day');
// add him since we're not adding him on the previous loop
$dates[] = $lastDayCalendar;
//while the day is not the last of the week
while ($lastDayCalendar->format('w') != 6) {
    // get the immediate day after
    $lastDayCalendar = $lastDayCalendar->modify('+1 day');
    // and add it to the dates array
    $dates[] = $lastDayCalendar;
}
// sorting the array to make sure the first dates are the first to be shown
usort($dates, static function (DateTimeImmutable $a, DateTimeImmutable $b) {
    return $a->getTimestamp() - $b->getTimestamp();
});
$gameDates = array_flip(\app\models\Games::find()->select('valid_date')->column());
?>
<div class="calendar calendar-first" id="calendar_first">
    <div class="calendar_header">
        <?= \yii\helpers\Html::a('<', ['site/index', 'month' => $prevMonth->format('M-Y'), '#' => 'calendar_first'], ['class' => 'switch-month switch-right']) ?>
        <h2><?= $dateMonth->format('F Y') ?></h2>
        <?= \yii\helpers\Html::a('>', ['site/index', 'month' => $nextMonth->format('M-Y'), '#' => 'calendar_first'], ['class' => 'switch-month switch-right']) ?>
    </div>
    <div class="calendar_weekdays">
        <div style="color: rgb(68, 68, 68);">Sun</div>
        <div style="color: rgb(68, 68, 68);">Mon</div>
        <div style="color: rgb(68, 68, 68);">Tue</div>
        <div style="color: rgb(68, 68, 68);">Wed</div>
        <div style="color: rgb(68, 68, 68);">Thu</div>
        <div style="color: rgb(68, 68, 68);">Fri</div>
        <div style="color: rgb(68, 68, 68);">Sat</div>
    </div>
    <div class="calendar_content">
        <?php foreach ($dates as $date) : ?>
            <?php
            $options = [];
            // if the date month is not the calendars month it will not show
            if ($date->format('m') !== $dateMonth->format('m')) {
                \yii\helpers\Html::addCssClass($options, 'blank');
            } // if the date is the same month of the calendar but before today
            else if ($date->getTimestamp() < $today->getTimestamp()) {
                \yii\helpers\Html::addCssClass($options, 'past-date');
            } // if the date is the same as today
            else if ($date->format('y-m-d') === date('y-m-d')) {
                \yii\helpers\Html::addCssClass($options, 'today');
            } else {
                \yii\helpers\Html::addCssClass($options, 'future');
            }
            \yii\helpers\Html::addCssClass($options, isset($gameDates[$date->format('Y-m-d')]) ? 'has-game' : 'no-game');
            // rendering the tag with the right classes
            echo \yii\helpers\Html::tag('div', $date->format('d'), $options)
            ?>
        <?php endforeach; ?>
    </div>
</div>
