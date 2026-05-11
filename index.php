<?php

error_reporting(0);

require_once 'apiConnection.php';

// Global variable for pushEvent function only
$activity = [];

$filterEvent = $argv[2];

$pushEventRepo = [];
$events = json_decode($response, true);

function pushEvent($pushEventRepo): void
{
    global $activity;

    // Count the values in the array, in this case the occurences of every repo, meaning the commits to every repo
    $commits = array_count_values($pushEventRepo);

    foreach ($commits as $key => $value) {
        // $activity .= "Pushed $value commits to $key\n";
        $activity["Pushed {$value} commit(s) to {$key}\n"] = 'PushEvent';
    }
}

// Filters by event type
function filter($event, $filteredActivities, $activity): string
{
    foreach ($activity as $key => $value) {
        if ($value == $event) {
            $filteredActivities .= $key;
        }
    }

    if (empty($filteredActivities)) {
        $filteredActivities .= "Sorry, that isn't a valid filter";
    }

    return $filteredActivities;
}

if ($curlError) {
    echo 'Error: '.curl_error($ch);
} elseif ('Not Found' == $events['message']) {
    echo "\n\n\n\nUser not found";
} else {
    foreach ($events as $event) {
        switch ($event['type']) {
            case 'PushEvent':
                array_push($pushEventRepo, $event['repo']['name']); // Push every repo name with a push event to the evenRepo

                break;

            case 'WatchEvent':
                $activity["Starred {$event['repo']['name']} \n"] = 'WatchEvent';

                break;

            case 'IssuesCommentEvent':
                $activity["Starred {$event['payload']['action']}\n"] = 'IssuesCommentEvent';

                break;

            case 'IssuesEvent':
                $activity["{$event['payload']['action']} an issue in {$event['repo']['name']}\n"] = 'IssuesEvent';

                break;

            case 'MemberEvent':
                $activity["Member : {$event['payload']['action']}\n"] = 'MemberEvent';

                break;

            case 'CommitCommentEvent':
                $activity["Commit comment {$event['payload']['action']}\n"] = 'CommitCommentEvent';

                break;

            case 'CreateEvent':
                $activity["Branch \"{$event['payload']['ref']}\" created\n"] = 'CreateEvent';

                break;

            case 'DeleteEvent':
                $activity["Branch \"{$event['payload']['ref']}\" deleted \n"] = 'DeleteEvent';

                break;

            case 'DiscussionEvent':
                $activity["Discussion {$event['payload']['action']} \n"] = 'DiscussionEvent';

                break;

            case 'ForkEvent':
                $activity["{$event['payload']['action']} {$event['payload']['forkee']['name']}\n"] = 'ForkEvent';

                break;

            case 'GollumEvent':
                $activity["Page {$event['pages']['']['action']} : {$event['pages']['']['name']} \n"] = 'GollumEvent';

                break;

            case 'PullRequestEvent':
                $activity["Pull request \"{$event['payload']['number']}\" {$event['payload']['action']} \n"] = 'PullRequestEvent';

                break;
        }
    }

    pushEvent($pushEventRepo);

    if (isset($filterEvent)) {
        $filteredActivities = filter($filterEvent, $filteredActivities, $activity);
        echo $filteredActivities;
    } else {
        echo implode(' ', array_keys($activity));
    }
}

// 1. Initialize cURL session
// $ch = curl_init();

// // 2. Set options
// curl_setopt($ch, CURLOPT_URL, "https://api.github.com/users/dj2313/events");
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Returns the response as a string instead of outputting it directly
// curl_setopt($ch, CURLOPT_USERAGENT, 'SSJ4K'); // Github needs this to verify who is making the request

// // 3. Execute and store response
// $response = curl_exec($ch);

// $a = json_decode($response, true);
// if (curl_error($ch)) {
//     echo 'Error: ' . curl_error($ch);
// } else {
//     // Process your response (e.g., json_decode if it's an API)

//    print_r(json_decode($response, true));
// }

?>









