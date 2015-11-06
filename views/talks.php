<?php
$additionalHeader = <<<EOF
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="/js/joindin-ratings.min.js"></script>
EOF;
require_once('header.php');

function renderTalk(array $talk)
{
    $s = '<li>';

    $s .= '<h3>';
    if ($talk['type'] === 'tutorial') {
        $s .= '<strong>Tutorial: </strong>';
    }
    if ($talk['type'] === 'lightning') {
        $s .= '<em>Lightning: </em>';
    }
    $s .= $talk['name'];
    $s .= ' (' . $talk['event'] . ', ' . $talk['date']->format('jS M \'y') . ')';
    $s .= '</h3>';

    $s .= '<p>' . $talk['abstract'] . '</p>';

    $links = [];
    foreach ($talk['links'] as $text => $linkData) {
        $l = '<a href="';
        $l .= $linkData['url'];
        if (isset($linkData['class'])) {
            $l .= '" class="' . $linkData['class'] . '"';
        }
        $l .= '">' . $text . '</a>';
        $links[] = $l;
    }

    if (count($links)) {
        $s .= '<p><strong>Links: </strong> ';
        $s .= implode(' | ', $links);
        $s .= '</p>';
    }

    $s .= '</li>';
    return $s;
}

?>

<p>Upcoming talks:</p>

<?php
if (count($upcoming)) {
    echo '<ul>';
    foreach ($upcoming as $t) {
        echo renderTalk($t);
    }
    echo '</ul>';
} else {
    echo '<p>No upcoming talks...</p>';
}
?>

<p>This is a list of talks I've given:</p>

<?php
echo '<ul>';
foreach ($past as $t) {
    echo renderTalk($t);
}
echo '</ul>';
?>

<?php require_once('footer.php'); ?>
