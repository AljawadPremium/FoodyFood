<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    /**
     * Email sender address
     */
    public $fromEmail = 'sse@foodyfc.com.sa';

    /**
     * Email sender name
     */
    public $fromName = 'FoodyFC';

    /**
     * Default recipients (optional)
     */
    public $recipients = '';

    /**
     * The "user agent"
     */
    public $userAgent = 'CodeIgniter';

    /**
     * Mail protocol
     */
    public $protocol = 'smtp';

    /**
     * Sendmail path (not used for SMTP)
     */
    public $mailPath = '/usr/sbin/sendmail';

    /**
     * ✅ ZOHO SMTP SETTINGS
     */
    public $SMTPHost = 'smtp.zoho.com';
    public $SMTPUser = 'sse@foodyfc.com.sa';
    public $SMTPPass = 'r6Y2D3uXiwar';
    public $SMTPPort = 465;
    public $SMTPTimeout = 10;
    public $SMTPCrypto = 'ssl';
    public $SMTPKeepAlive = false;

    /**
     * Email format
     */
    public $mailType = 'html';
    public $charset  = 'UTF-8';
    public $wordWrap = true;
    public $wrapChars = 76;

    /**
     * Email priority
     */
    public $priority = 3;

    /**
     * New lines
     */
    public $CRLF    = "\r\n";
    public $newline = "\r\n";

    /**
     * BCC settings
     */
    public $BCCBatchMode = false;
    public $BCCBatchSize = 200;

    /**
     * Delivery Status Notification
     */
    public $DSN = false;
}
