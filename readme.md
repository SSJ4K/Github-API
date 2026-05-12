Prerequsites:

- PHP 7.4 and above
- XAMPP

Setup:

Install XAMPP and clone this repo into the htdocs folder. Then open the shell from xampp and navigate to the repo.

run: php github-user <username> to get all recent activity from the user.

You can add an event filter aswell: php github-activity <username> PushEvent.

Here is a list of all the events:

PushEvent
WatchEvent
IssuesCommentEvent
IssuesEvent
MemberEvent
CommitCommentEvent
CreateEvent
DeleteEvent
DiscussionEvent
ForkEvent
GollumEvent
PullRequestEvent
