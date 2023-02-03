<?php

use BaseCRM\ServerSide\Lead;

$agent_name = BaseCRM::agent_name(get_current_user_id(), 'first');

?>

<div class="row" id="vtp-script-container">
    <div class="col">
        <p class="h4">Virtual Tax Pro</p>
        <p class="lead">Hi <span class="lead-first-name">[client name]</span> <span class="script-reminder">(assume prospects name and pause)</span></p>
        <p class="lead">
            Hi <span class="lead-first-name">[client name]</span> this is <span class="agent-name"><?php echo $agent_name ?></span> with The Johnson Group. We gave you the <span class="no-cost-policy">[no cost offer]</span> back in <span class="wcn-date">[date of appointment]</span>. I'm calling because we are now offering virtual
            tax services, and would like to help you file this year. Have you already filed your taxes? Do you have everything you need in order to file?
        </p>
        <p class="lead">
            <strong>1.</strong> I'm going to send you an email with a link to create your account and upload your information. <span class="script-reminder">(confirm or collect email address)</span>
        </p>
        <div class="row mb-3">
            <div class="col-12">
                <p class="h4">What is your email address?</p>
                <div class="input-group has-validation mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                    <input type="text" class="form-control" name="lead-email" id="lead-email" placeholder="Email Address" aria-label="Email Address" aria-describedby="lead-email">
                    <span class="invalid-feedback"></span>
                </div>
            </div>
            <div class="col-12">

                <button id="send-client-registration-email" class="btn btn-primary w-100"><i class="fa-solid fa-envelope"></i> Send Client Registration Email</button>
            </div>
        </div>
        <p class="lead">
            <strong>2.</strong> Go ahead and create your account. This is how you can check the status of your filing. Any time we update your file you will receive a text message, and you can visit your account for details.
        </p>
        <p class="lead">
            <strong>3.</strong> Once your account is created and your files are uploaded you can expect completion in the next 24-48 hours. At that time we will connect with you to go over your return, collect signatures, and complete your filing.
        </p>
        <p class="lead">When should we expect everything to be handled on your end?</p>
        <!-- Conversation Notes Textarea -->
        <div class="row">
            <div class="col-12">
                <div class="form-floating">
                    <textarea name="conversation-notes" id="conversation-notes" class="form-control mb-3" style="height: 115px;"></textarea>
                    <label for="conversation-notes">Conversation Notes</label>
                </div>
            </div>
        </div>
        <p class="lead">Do me a favor and check your email, I want to make sure that you got the link I just sent over.</p>
    </div>
</div>