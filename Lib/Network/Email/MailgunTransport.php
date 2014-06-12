<?php
/**
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author        Codaxis - https://github.com/codaxis
 * @link          https://github.com/Codaxis/cakephp-mailgun
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Mailgun\Mailgun;

/**
 * MailgunTransport class
 * Enables sending of email via Mailgun SDK
 */
class MailgunTransport extends AbstractTransport {

/**
 * Configurations
 *
 * @var array
 */
	protected $_config = array();

/**
 * Email header to Mailgun param mapping
 *
 * @var array
 */
    protected $_paramMapping = array(
        'From' => 'from',
        'To' => 'to',
        'Cc' => 'cc',
        'Bcc' => 'bcc',
        'Subject' => 'subject',
        'Reply-To' => 'h:Reply-To',
        'Disposition-Notification-To' => 'h:Disposition-Notification-To',
        'Return-Path' => 'h:Return-Path',

        'o:tag' => 'o:tag',
        'mg:tag' => 'o:tag',
        'X-Mailgun-Tag' => 'o:tag',
        'o:campaign' => 'o:campaign',
        'mg:campaign' => 'o:campaign',
        'X-Mailgun-Campaign-Id' => 'o:campaign',
        'o:dkim' => 'o:dkim',
        'mg:dkim' => 'o:dkim',
        'X-Mailgun-Dkim' => 'o:dkim',
        'o:deliverytime' => 'o:deliverytime',
        'mg:deliverytime' => 'o:deliverytime',
        'X-Mailgun-Deliver-By' => 'o:deliverytime',

        'o:testmode' => 'o:testmode',
        'mg:testmode' => 'o:testmode',
        'X-Mailgun-Drop-Message' => 'o:testmode',

        'o:tracking' => 'o:tracking',
        'mg:tracking' => 'o:tracking',
        'X-Mailgun-Track' => 'o:tracking',

        'o:tracking-clicks' => 'o:tracking-clicks',
        'mg:tracking-clicks' => 'o:tracking-clicks',
        'X-Mailgun-Track-Clicks' => 'o:tracking-clicks',

        'o:tracking-opens' => 'o:tracking-opens',
        'mg:tracking-opens' => 'o:tracking-opens',
        'X-Mailgun-Track-Opens' => 'o:tracking-opens',

    );

/**
 * Send email via Mailgun
 *
 * @param CakeEmail $email
 * @return array
 */
	public function send(CakeEmail $email) {
		$mgClient = new Mailgun($this->_config['mg_api_key']);

        $headersList = array('from', 'sender', 'replyTo', 'readReceipt', 'returnPath', 'to', 'cc', 'bcc', 'subject');
        $params = [];
        foreach ($email->getHeaders($headersList) as $header => $value) {
            if (isset($this->_paramMapping[$header]) && !empty($value)) {
                $key = $this->_paramMapping[$header];
                $params[$key] = $value;
            }
        }

        $params['text'] = $email->message(CakeEmail::MESSAGE_TEXT);
        $params['html'] = $email->message(CakeEmail::MESSAGE_HTML);

        $attachments = array();
        foreach ($email->attachments() as $name => $info) {
        	$attachments['attachment'][] = '@' . $info['file'];
        }

		try {
			$result = $mgClient->sendMessage($this->_config['mg_domain'], $params, $attachments);
			if ($result->http_response_code != 200) {
				throw new Exception($result->http_response_body->message);
			}
		} catch (Exception $e) {
			throw $e;
		}

        return $result;
    }
}
