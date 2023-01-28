<?php

/**
 * Modal container for Presentation Form
 */

use BaseCRM\ServerSide\Lead;

// Get the current user
$user = wp_get_current_user();
$user_id = $user->ID;
$user_name = BaseCRM::agent_name($user_id);

// Get scripts
$scripts = new Lead();
$scripts = $scripts->lead_types();

?>

<!-- Modal -->
<div class="modal fade" id="presentation-modal" tabindex="-1" role="dialog" aria-labelledby="presentation-modal-header" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="presentation-modal-header">Presentation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <?php echo BaseCRM::snip('presentation-form'); ?>
            </div>
            <div class="modal-footer">
                <button id="previous-button" class="btn btn-primary" disabled><i class="fa-solid fa-arrow-left"></i>&nbsp;Previous</button>
                <button id="next-button" class="btn btn-primary" disabled>Next&nbsp;<i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
    </div>
</div>