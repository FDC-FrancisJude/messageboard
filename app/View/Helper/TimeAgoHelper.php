<?php
// app/View/Helper/TimeAgoHelper.php
class TimeAgoHelper extends AppHelper {

    public function timeAgo($timestamp) {
        $now = new DateTime('now', new DateTimeZone('Asia/Manila'));
        $created = new DateTime($timestamp, new DateTimeZone('Asia/Manila'));
        $interval = $now->diff($created);

        if ($interval->y > 0) {
            return $interval->format('%y years ago');
        } elseif ($interval->m > 0) {
            return $interval->format('%m months ago');
        } elseif ($interval->d > 0) {
            return $interval->format('%d days ago');
        } elseif ($interval->h > 0) {
            return $interval->format('%h hours ago');
        } elseif ($interval->i > 0) {
            return $interval->format('%i minutes ago');
        } else {
            return $interval->format('%s seconds ago');
        }
    }

    public function formalDate($dateTimeString)
    {
        $timestamp = strtotime($dateTimeString);
        return date("F j, Y g:i A", $timestamp);
    }

}

?>