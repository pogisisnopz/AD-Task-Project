<?php
function renderUserCard(array $user): string {
    return "
    <div class='card'>
        <h3>{$user['first_name']} {$user['last_name']}</h3>
        <p>Username: {$user['username']}</p>
        <p>Role: {$user['role']}</p>
    </div>
    ";
}
