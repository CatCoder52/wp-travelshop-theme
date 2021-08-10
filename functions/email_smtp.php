<?php
/**
 * Enable SMTP auth support,
 * constants are defined in config-theme.php
 */
if (SMTP_ACTIVE === true) {
    add_action('phpmailer_init', function ($phpmailer) {
        $phpmailer->isSMTP();
        $phpmailer->Host = SMTP_HOST;
        $phpmailer->SMTPAuth = SMTP_AUTH;
        $phpmailer->Port = SMTP_PORT;
        $phpmailer->Username = SMTP_USER;
        $phpmailer->Password = SMTP_PASS;
        $phpmailer->SMTPSecure = SMTP_SECURE;
        $phpmailer->From = SMTP_FROM_EMAIL;
        $phpmailer->FromName = SMTP_FROM_NAME;
    });
}
