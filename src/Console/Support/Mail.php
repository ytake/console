<?php
namespace Comnect\Console\Support;

use Comnect\Console\Support\Interfaces\ConfigInterface;

/**
 * Class Mail
 * @package Comnect\Support
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Mail
{

    /** @var \Swift_Mailer */
    protected $mailer;

    /** @var  ConfigInterface */
    protected $config;

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->message = \Swift_Message::newInstance();
        $this->config = $config;
    }

    /**
     * get mail
     */
    public function getMailer()
    {
        return $this;
    }

    /**
     * set subject
     * @param string $subject
     * @return \Swift_Mime_SimpleMessage
     */
    public function subject($subject)
    {
        $this->message->setSubject($subject);
        return $this;
    }

    /**
     * set from addresses
     * @param array $addresses
     * @param null|string $name
     * @return \Swift_Mime_SimpleMessage
     */
    public function from(array $addresses, $name = null)
    {
        $this->message->setFrom($addresses, $name);
        return $this;
    }

    /**
     * set to
     * @param array $addresses
     * @param null|string $name
     * @return \Swift_Mime_SimpleMessage
     */
    public function to(array $addresses, $name = null)
    {
        $this->message->setTo($addresses, $name);
        return $this;
    }

    /**
     * set body
     * @param string $body
     * @param null $contentType
     * @param null $charset
     * @return $this
     */
    public function body($body, $contentType = null, $charset = null)
    {
        $this->message->setBody($body, $contentType, $charset);
        return $this;
    }

    /**
     * attach
     * @param null $data
     * @param null $filename
     * @param null $contentType
     * @return $this
     */
    public function attach($data = null, $filename = null, $contentType = null)
    {
        $this->message->attach(\Swift_Attachment::newInstance($data, $filename, $contentType));
        return $this;
    }


    /**
     * send mail
     * @return int
     */
    public function send()
    {
        $mailConfigure = $this->config->get('mail');
        switch($mailConfigure['driver'])
        {
            case 'sendmail':
                $transport = \Swift_SendmailTransport::newInstance($mailConfigure['sendmail']);
                break;

            case 'smtp':
                $transport = \Swift_SmtpTransport::newInstance(
                    $mailConfigure['host'], $mailConfigure['port'], $mailConfigure['protocol']);

                if(!is_null($mailConfigure['account'])) {
                    $transport->setUsername($mailConfigure['account']);
                }

                if(!is_null($mailConfigure['password'])) {
                    $transport->setPassword($mailConfigure['password']);
                }
                break;
        }
        $mailer = \Swift_Mailer::newInstance($transport);
        return $mailer->send($this->message);
    }
}