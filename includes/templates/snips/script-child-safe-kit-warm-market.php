<?php

/** Child Safe Kit
 * Warm Market Script
 */

use BaseCRM\ServerSide\Lead;

$agent_name = BaseCRM::agent_name(get_current_user_id(), 'first');

?>

<div class="row d-none" id="cskw-script-container">
    <div class="col">
        <p class="h4">Child Safe Kit - Warm Market Script</p>
        <p class="lead">Hi <span class="lead-first-name">[client name]</span> <span class="script-reminder">(pause and wait for affirmation)</span></p>
        <p class="lead">
            Hi <span class="lead-first-name">[client name]</span>, I'm calling because I've started a new job, and the company I'm with does a lot to help the community. 
            Right now, we're giving away our child safe program, and I want to make sure you get this. One of the features of the program is a child safe app. 
            With it, you can upload pictures, physical descriptions, and even fingerprints of your kids, so if God forbid they went missing, you would have everything you need to give to the authorities.
        </p>
        <p class="lead">
            There's no cost for the program, I just want to know what time tomorrow evening would be best to go over everything? <span class="script-reminder">(find out if they have plans or post-work routines, build rapport)</span>
        </p>
    </div>
</div>