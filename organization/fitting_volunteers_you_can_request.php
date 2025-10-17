<?php
$rejected = $singleOpportuity->getRejected($opportunity->id);

/*
 * Tablica ID na potrzeby wykluczenia ich z fitted
 */
$rejectedIDs = array();
foreach ($rejected as $reject) {
    $rejectedIDs[] = $reject->user_id;
}

$applied = $singleOpportuity->getApplied($opportunity->id);

/*
 * Tablica ID na potrzeby wykluczenia ich z fitted
 */
$appliedIDs = array();
foreach ($applied as $apply) {
    $appliedIDs[] = $apply->user_id;
}

$requested = $singleOpportuity->getRequested($opportunity->id);

/*
 * Tablica ID na potrzeby wykluczenia ich z fitted
 */
$requestedIDs = array();
foreach ($requested as $request) {
    $requestedIDs[] = $request->user_id;
}

$currentUsers = $singleOpportuity->getInProgress($opportunity->id);

/*
 * Tablica ID na potrzeby wykluczenia ich z fitted
 */
$currentIDs = array();
foreach ($currentUsers as $currentUser) {
    $currentIDs[] = $currentUser->user_id;
}

$completedUsers = $singleOpportuity->getCompletedEngagement($opportunity->id);

/*
 * Tablica ID na potrzeby wykluczenia ich z fitted
 */
$completedIDs = array();
foreach ($completedUsers as $completedUser) {
    $completedIDs[] = $completedUser->user_id;
}

/*
* Wykluczenie applied z fitted
*/
foreach ($matchedUsers as $userId => $user) {
    foreach ($rejectedIDs as $rejectedID) {
        if ($userId == $rejectedID) {
            unset($matchedUsers[$userId]);
        }
    }
}

foreach ($matchedUsers as $userId => $user) {
    foreach ($requestedIDs as $requestedID) {
        if ($userId == $requestedID) {
            unset($matchedUsers[$userId]);
        }
    }
}

foreach ($matchedUsers as $userId => $user) {
    foreach ($appliedIDs as $appliedID) {
        if ($userId == $appliedID) {
            unset($matchedUsers[$userId]);
        }
    }
}

foreach ($matchedUsers as $userId => $user) {
    foreach ($currentIDs as $currentID) {
        if ($userId == $currentID) {
            unset($matchedUsers[$userId]);
        }
    }
}

foreach ($matchedUsers as $userId => $user) {
    foreach ($completedIDs as $completedID) {
        if ($userId == $completedID) {
            unset($matchedUsers[$userId]);
        }
    }
}