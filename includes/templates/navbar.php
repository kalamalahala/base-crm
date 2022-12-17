<?php
    // use BaseCRM\BaseCRM;
    $plugin_page_ids = BaseCRM::plugin_page_ids();
    extract($plugin_page_ids, EXTR_PREFIX_ALL, 'page');
    
    $home_active = $page_basecrm == get_the_ID() ? 'px-2 active' : 'px-0';
    $leads_active = $page_basecrm_leads == get_the_ID() ? 'px-2 active' : 'px-0';
    $appointments_active = $page_basecrm_appointments == get_the_ID() ? 'px-2 active' : 'px-0';
    $logs_active = $page_basecrm_logs == get_the_ID() ? 'px-2 active' : 'px-0';
    $settings_active = $page_basecrm_settings == get_the_ID() ? 'px-2 active' : 'px-0';

    $disabled = current_user_can('administrator') ? '' : 'class="disabled"';
    
?>
<?php echo BaseCRM::snip('modal-create-lead-form'); ?>
<?php echo BaseCRM::snip('modal-call-lead'); ?>
<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark" id="plugin-navbar">
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
        <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <img src="<?php echo get_site_icon_url(30, BaseCRM_PLUGIN_URL . 'includes/logo.png'); ?>" class="rounded-circle" width="30" height="30" />&nbsp;<span class="d-none d-sm-inline">BaseCRM</span>
        </a>
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <li class="nav-item">
                <a href="<?php echo get_permalink($page_basecrm); ?>" class="nav-link align-middle <?php echo $home_active; ?>">
                    <i class="fa-solid fa-home"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                </a>
            </li>
            <li>
                <a href="<?php echo get_permalink($page_basecrm_leads); ?>" class="nav-link align-middle <?php echo $leads_active; ?>">
                    <i class="fa-regular fa-user"></i> <span class="ms-1 d-none d-sm-inline">Leads</span>
                </a>
            </li>
            <li>
                <a href="<?php echo get_permalink($page_basecrm_appointments); ?>" class="nav-link align-middle <?php echo $appointments_active; ?>">
                    <i class="fa-regular fa-calendar-days"></i> <span class="ms-1 d-none d-sm-inline">Appointments</span>
                </a>
            </li>
            <li <?php echo $disabled; ?>>
                <a href="<?php echo BaseCRM::disable_permalink_if_not_admin($page_basecrm_logs); ?>" class="nav-link align-middle <?php echo $logs_active; ?>">
                    <i class="fa-solid fa-list-check"></i> <span class="ms-1 d-none d-sm-inline">Logs</span>
                </a>
            </li>
            <li <?php echo $disabled; ?>>
                <a href="<?php echo BaseCRM::disable_permalink_if_not_admin($page_basecrm_settings); ?>" class="nav-link align-middle <?php echo $settings_active; ?>">
                    <i class="fa-solid fa-gear"></i> <span class="ms-1 d-none d-sm-inline">Settings</span>
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown pb-4">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?php echo (get_avatar_url(get_current_user_id())) ? get_avatar_url(get_current_user_id()) : ''; ?>" alt="" width="30" height="30" class="rounded-circle">
                <span class="d-none d-sm-inline mx-1"><?php echo wp_get_current_user()->display_name; ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a href="#" class="dropdown-item link-create-new-lead" data-bs-toggle="modal" data-bs-target="#modal-create-lead"><i class="fa-solid fa-user-plus"></i>&nbsp;&nbsp;Create New Lead</a></li>
                <li><a href="#" class="dropdown-item link-create-new-appointment"><i class="fa-regular fa-calendar-plus"></i>&nbsp;&nbsp;New Appointment</a></li>
                <li><a href="<?php echo BaseCRM::disable_permalink_if_not_admin($page_basecrm_settings); ?>" class="dropdown-item"><i class="fa-solid fa-gear"></i>&nbsp;&nbsp;Settings</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a href="<?php echo home_url(); ?>" class="dropdown-item"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;&nbsp;Sign Out</a></li>
            </ul>
        </div>
    </div>
</div>