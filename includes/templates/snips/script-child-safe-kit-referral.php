<?php

/** Child Safe Kit
 * Warm Market Script
 */

use BaseCRM\ServerSide\Lead;

$agent_name = BaseCRM::agent_name(get_current_user_id(), 'first');
$user_id = get_current_user_id();

?>

<div class="row d-none" id="cskr-script-container">
    <div class="col">
        <p class="h4">Child Safe Kit - Referral Script</p>
        <p class="lead">Hi <span class="lead-first-name">[client name]</span> <span class="script-reminder">(pause and wait for affirmation)</span>
        </p>
        <p class="lead">
            Hi <span class="lead-first-name">[client name]</span> this is <span
                    class="agent-name"><?php echo $agent_name ?></span> with The Johnson Group. I got your number from
            your
            <span class="referral-text lead-relationship">(relationship)</span> <span
                    class="referral-text lead-referred-by">(referrer name)</span>, Did you get the message that I would
            be calling?
        </p>
        <p class="lead">
            <strong>Yes/No</strong>: Awesome/OK, I’m not sure if you know this or not, but several hundred thousand kids
            are reported missing every year, and Florida ranks number 1 in the nation for missing children, so the
            program gives you access to several resources that both educate and help you to keep your children safe. The
            entire program can be accessed online and there is NO-COST to join.

            To get you set up and walk you through how it all works will take about 15 to 20 minutes, do you have time
            now or is there a better time to call you back?
        </p>
        <p class="lead">
            <strong>No, later</strong>: <a href="#" class="btn btn-primary btn-sm" id="test-ajax">
                <?php echo BaseCRM::i18n('Test Ajax'); ?>
            </a>
        </p>

        <p class="lead">
            <strong>Yes, time now</strong>: Again there are several hundred thousand kids who go missing in
            our country every year, and you know what it’s like to lose sight of your kids for just a few seconds.
        </p>
        <p class="lead">That feeling that you get, it’s like your heart stops, you start to panic, It’s like you’re
            holding your
            breath
            waiting to see them.</p>

        <p class="lead">Imagine if those seconds turned to minutes, and the minutes turned to hours. Study’s show that
            every hour a
            child is missing, adds 60 miles in any direction that they could be. And according to the FBI 93% of
            abducted children are killed within the first 24 hours of being taken. And if that’s not bad enough, human
            trafficking is on the rise.</p>
        <p class="lead">Over 200,000 children are at risk of being abducted every year, so for these
            reasons our organization has created a child safe program designed to educate you as a parent, and to
            provide you with resources that you can utilize to monitor and help keep your child/children safe.</p>

        <p class="lead">A major feature that comes included with the program is the TJG Kids Kit, it allows you to keep
            all
            pertinent info about your child in one place, like pictures, finger prints, and physical descriptions, this
            way if you ever need to utilize the kit, you’ll be able to share it via email right from your phone. You’ll
            also have access to a variety of other services related to keeping your child(ren) safe, like offender
            searches and app monitoring systems for your child’s mobile devices.</p>
        <p class="lead">
            Heaven forbid if your child were to go missing, time is of the essence, and with technology today, this
            child safe program puts you in the greatest
            position of strength, to help authorities find your child quickly, and protect them from potential
            predators.</p>
        <p class="lead">
            Before we end our call you’ll receive an email that will grant you access to the entire program. Please take
            advantage of all that it offers as soon as possible.
        </p>
        <p class="lead">
            <span class="lead-first-name">[client name]</span> we’ve made a commitment to get this program to every
            parent possible, and to do that we need your help. You help by providing the contact information for every
            parent you know, so we can protect their children as well. Who’s the first parent that comes to mind?
        </p>
        <form action="" id="referrals-form">
            <input type="hidden" name="user-id" value="<?php echo $user_id; ?>">
            <input type="hidden" name="lead-id" value="0">
            <input type="hidden" name="appointment-id" value="0">
            <div class="referrals-form-container mb-5"> <!-- Referrals Form -->

                <div class="row">
                    <div class="col">
                        <p class="h1">Collect Referrals <span class="badge bg-primary" id="referral-count"><span
                                        class="referral-count-num">0</span> <i class="fa-solid fa-user"></i></span></p>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="text" name="referral-first-name" placeholder="First Name"
                                   id="firstNameFloating"
                                   class="form-control" form="referrals-form">
                            <label for="firstNameFloating">First Name</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="text" name="referral-last-name" placeholder="Last Name" id="lastNameFloating"
                                   class="form-control" form="referrals-form">
                            <label for="lastNameFloating">Last Name</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <input type="text" name="referral-spouse-name" placeholder="Spouse's Name"
                                       id="spouseNameFloating" class="form-control" form="referrals-form">
                                <label for="spouseNameFloating">Spouse's Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group has-validation mb-3">
                            <div class="form-floating">
                                <input type="text" name="referral-phone" placeholder="Phone Number" id="phoneFloating"
                                       class="form-control" form="referrals-form">
                                <label for="phoneFloating">Phone</label>
                            </div>
                            <div class="invalid-feedback">
                                Enter a valid phone number.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <!-- Relationship to Referrer Text -->
                        <div class="form-floating mb-3">
                            <input type="text" name="relationship-to-referrer" placeholder="Relationship to Referrer"
                                   id="relationshipToReferrerFloating" class="form-control" form="referrals-form">
                            <label for="relationshipToReferrerFloating">Relationship to Referrer</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating mb-3">
                        <textarea class="form-control" name="referral-notes" id="referralNotesFloating"
                                  style="height:100px;" placeholder="Notes"></textarea>
                            <label for="referralNotesFloating">Notes</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <!-- Submit #referrals-form -->
                        <button type="button" class="btn btn-primary btn-lg btn-whos-next">Who's Next?</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible fade show d-none" id="referral-success"
                             role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>Success!</strong> <span class="alert-first-name">[client name]</span> has been added
                            to
                            your referral list.
                        </div>

                        <div class="alert alert-danger alert-dismissible fade show d-none" id="referral-error"
                             role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>Error!</strong> <span class="alert-first-name">[client name]</span> has already been
                            added to your referral list.
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </p>
        <div class="row">
            <div class="col">
                <h4>Name and Phone Number</h4>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                            <input type="text" class="form-control" name="lead-first-name"
                                   id="lead-first-name" placeholder="First Name" aria-label="First Name"
                                   aria-describedby="lead-first-name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                            <input type="text" class="form-control" name="lead-last-name"
                                   id="lead-last-name" placeholder="Last Name" aria-label="Last Name"
                                   aria-describedby="lead-last-name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                            <input type="text" class="form-control" name="lead-phone" id="lead-phone"
                                   placeholder="Phone Number" aria-label="Phone Number"
                                   aria-describedby="lead-phone">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p class="h4">What is your email address?</p>
                <div class="input-group has-validation mb-3">
                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                    <input type="text" class="form-control" name="lead-email" id="lead-email"
                           placeholder="Email Address" aria-label="Email Address"
                           aria-describedby="lead-email">
                    <span class="invalid-feedback"></span>
                </div>
            </div>
        </div>
        <p class="lead">
            <a href="javascript:void(0);" class="btn btn-primary btn-lg btn-block" id="btn-continue">Send Child Safe Email & SMS</a>
            <script>
                jQuery(document).ready(function () {
                    jQuery('#btn-continue').click(function () {
                        let leadId = jQuery('#lead-id').val();

                        let url = 'https://thejohnson.group/agent-portal/csp-emailer/?lead_id=' + leadId;
                        let oldUrl = 'http://migrate-test.local/wp-json/basecrm/v1/get_calendar_invite_form/?lead_id=' + leadId;
                        // open a small window with no address bar, toolbars etc
                        window.open(url,
                            'Child Safe Emailer & SMS',
                            'width=500,height=500,scrollbars=no,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0');

                        // jQuery.get(url, function (data) {
                        //     console.log(data);
                        //     jQuery('#fetch-container').html(data);
                        // });
                        //
                        // jQuery('#modal-calendar-invite').modal('show');
                    });
                });
            </script>
        </p>
        <hr/>
        <p class="lead">
            <span class="lead-first-name">[client name]</span>, the message you just received is for you to forward to
            those that you referred, so they don't think I am a telemarketer.
        </p>
        <p class="lead">
            To thank you for helping us to reach the community, I've been authorized to complete a FREE needs analysis.
        </p>
        <p class="lead">
            In addition to providing services like the child safe program, my company also provides financial relief to
            those who qualify with our insurance products. The products we offer pay you or your family in the event of
            sickness, accident, or even death, and even helps you to build wealth based on what you qualify for.
        </p>
        <p class="lead">
            Now <span class="lead-first-name">[client name]</span>, to be clear I’m not sure that you’ll qualify for any
            of these products, but if you do, your participation is completely optional and at your discretion. I'm
            going to ask you a few questions to see if it makes sense to proceed
        </p>

        <!--
        [client name] to thank you for helping us to reach the community, I've been authorized to complete a FREE needs analysis. In addition to providing services like the child safe program, my company also provides financial relief to those who qualify with our insurance products. The products we offer pay you or your family in the event of sickness, accident, or even death, and even helps you to build wealth based on what you qualify for. Now [client name], to be clear I’m not sure that you’ll qualify for any of these products, but if you do, your participation is completely optional and at your discretion. I'm going to ask you a few questions to see if it makes sense to proceed
        -->

        <!--        <a href="#" class="btn btn-primary btn-lg btn-block" id="btn-continue">Continue to Needs Analysis Script ...</a>-->
        <!--
				<p class="lead">
					<span class="lead-first-name">[client name]</span>, we've made a commitment to get this program to every
					parent possible, and to do that we need your help. You help by providing the contact information for every
					parent you know, so we can protect their children as well. Who’s the first parent that comes to mind?

					<strong>Yes</strong>: Ok, well I'm calling to give you the same child safe program that I gave <span
							class="referral-text lead-referred-by">(referrer name)</span>. The program offers a lot, but one of
					the main features is the child safe app. With it, you can upload pictures, physical descriptions, and even
					fingerprints of your kids, so if God forbid they went missing you would have everything you need to give to
					the authorities.
				</p>
				<p class="lead">
					There's no cost for the program, and I promised <span
							class="referral-text lead-referred-by">(referrer name)</span> that I would get you set up. I just
					need to know what time tomorrow evening would be best to go over everything? <span class="script-reminder">(find out if they have plans or post-work routines, build rapport)</span>
				</p> -->
    </div>
</div>