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
$firstDayOfCurrentMonth = $dateMonth->modify('first day of this month');
$lastDayOfCurrentMonth = $dateMonth->modify('last day of this month');
$dates = [];
$firstDayCalendar = $firstDayOfCurrentMonth->modify('+24 hours -1 day');
$dates[] = $firstDayCalendar;
while ($firstDayCalendar->format('w') != 0) {
    $firstDayCalendar = $firstDayCalendar->modify('-1 day');
    $dates[] = $firstDayCalendar;
}
$currentDay = $firstDayOfCurrentMonth->modify('+1 day');
while ($currentDay->getTimestamp() !== $lastDayOfCurrentMonth->getTimestamp()) {
    $dates[] = $currentDay;
    $currentDay = $currentDay->modify('+1 day');
}
$lastDayCalendar = $lastDayOfCurrentMonth->modify('+24 hours -1 day');
$dates[] = $lastDayCalendar;
while ($lastDayCalendar->format('w') != 6) {
    $lastDayCalendar = $lastDayCalendar->modify('+1 day');
    $dates[] = $lastDayCalendar;
}
usort($dates, static function (DateTimeImmutable $a, DateTimeImmutable $b) {
    return $a->getTimestamp() - $b->getTimestamp();
});
?>
<div class="calendar calendar-first" id="calendar_first">
    <div class="calendar_header">
        <?= \yii\helpers\Html::a('<', ['site/index', 'month' => $prevMonth->format('M-Y'),], ['class' => 'switch-month switch-right']) ?>
        <h2><?= $dateMonth->format('F Y') ?></h2>
        <?= \yii\helpers\Html::a('>', ['site/index', 'month' => $nextMonth->format('M-Y')], ['class' => 'switch-month switch-right']) ?>
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
            if ($date->format('m') !== $dateMonth->format('m')) {
                \yii\helpers\Html::addCssClass($options, 'blank');
            } else if ($date->getTimestamp() < $today->getTimestamp()) {
                \yii\helpers\Html::addCssClass($options, 'past-date');
            } else if ($date->format('y-m-d') === date('y-m-d')) {
                \yii\helpers\Html::addCssClass($options, 'today');
            }
            ?>
            <?= \yii\helpers\Html::tag('div', $date->format('d'), $options) ?>
        <?php endforeach; ?>
    </div>
</div>
