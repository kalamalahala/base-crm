<?php

/** Child Safe Kit
 * Warm Market Script
 */

use BaseCRM\ServerSide\Lead;

$agent_name = BaseCRM::agent_name(get_current_user_id(), 'first');

?>

<div class="row d-none" id="cskr-script-container">
    <div class="col">
        <p class="h4">Child Safe Kit - Referral Script</p>
        <p class="lead">Hi <span class="lead-first-name">[client name]</span> <span class="script-reminder">(assume prospects name and pause)</span></p>
        <p class="lead">
        Hi <span class="lead-first-name">[client name]</span> this is <span class="agent-name"><?php echo $agent_name ?></span>. I got your number from your
        <span class="referral-text lead-relationship">(relationship)</span> <span class="referral-text lead-referred-by">(referrer name)</span>, Did you get the text that I would be calling?
        </p>
        <p class="lead">
            <strong>Yes</strong>: Awesome, the program offers a lot, but one of the main features is the child safe app. With it, you can upload pictures, physical descriptions, and even fingerprints of your kids, so if God forbid they went missing, you would have everything you need to give to the authorities.
        </p>
        <p class="lead">
            <strong>No</strong>: Ok, well I'm calling to give you the same child safe program that I gave <span class="referral-text lead-referred-by">(referrer name)</span>. The program offers a lot, but one of the main features is the child safe app. With it, you can upload pictures, physical descriptions, and even fingerprints of your kids, so if God forbid they went missing you would have everything you need to give to the authorities.
        </p>
        <p class="lead">
            There's no cost for the program, and I promised <span class="referral-text lead-referred-by">(referrer name)</span> that I would get you set up. I just need to know what time tomorrow evening would be best to go over everything? <span class="script-reminder">(find out if they have plans or post-work routines, build rapport)</span>
        </p>
    </div>
</div>