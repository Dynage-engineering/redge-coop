<?php

namespace App\Notify;

use App\Lib\CurlRequest;
use App\Models\UserNotification;
use App\Notify\Notifiable;
use App\Notify\NotifyProcess;

class PushNotification extends NotifyProcess implements Notifiable {

    public $deviceTokens;
    /**
     * Assign value to properties
     *
     * @return void
     */
    public function __construct() {

        $this->statusField    = 'push_notification_status';
        $this->body           = 'push_notification_body';
        $this->globalTemplate = 'push_notification_body';
        $this->notifyConfig   = 'push_configuration';

    }

    /**
     * Send notification
     *
     * @return void|bool
     */
    public function redirectForApp($getTemplateName) {
        $screens = [
            'TRX_HISTORY'      => ['BAL_ADD', 'BAL_SUB', 'REFERRAL_COMMISSION', 'BALANCE_TRANSFER', 'BALANCE_RECEIVE'],
            'TRANSFER'         => ['OTHER_BANK_TRANSFER_COMPLETE', 'WIRE_TRANSFER_COMPLETED', 'OWN_BANK_TRANSFER_MONEY_SEND', 'OWN_BANK_TRANSFER_MONEY_RECEIVE', 'OTHER_BANK_TRANSFER_REQUEST_SEND'],
            'DEPOSIT_HISTORY'  => ['DEPOSIT_COMPLETE', 'DEPOSIT_APPROVE', 'DEPOSIT_REJECT', 'DEPOSIT_REQUEST'],
            'WITHDRAW_HISTORY' => ['WITHDRAW_APPROVE'],
            'LOAN_LIST'        => ['LOAN_APPROVE', 'LOAN_REJECT', 'LOAN_PAID', 'LOAN_INSTALLMENT_DUE'],
            'DPS_LIST'         => ['DPS_OPENED', 'DPS_MATURED', 'DPS_CLOSED', 'DPS_INSTALLMENT_DUE'],
            'FDR_LIST'         => ['FDR_OPENED', 'FDR_CLOSED'],
            'HOME'             => ['KYC_REJECT', 'KYC_APPROVE'],
        ];

        foreach ($screens as $screen => $array) {
            if (in_array($getTemplateName, $array)) {
                return $screen;
            }
        }
        return 'HOME';
    }

    public function send() {

        $message    = $this->getMessage();
        $subject    = $this->subject;
        $remark     = $this->template->act;
        $clickValue = $this->clickValue;
        if ($this->setting->pn && $message) {

            try {

                if ($this->user) {
                    $data['priority'] = 'high';
                    if (count($this->deviceTokens) > 0) {
                        $data = [
                            "registration_ids" => $this->deviceTokens,
                            "notification"     => [
                                'title'        => $subject,
                                'body'         => $message,
                                'icon'         => getImage(getFilePath('logoIcon') . '/logo.png'),
                                'click_action' => $clickValue,
                            ],
                            'data'             => [
                                'for_app' => $this->redirectForApp($this->templateName),
                            ],
                        ];

                        $dataString = json_encode($data);

                        $headers = [
                            'Authorization:key=' . $this->setting->push_configuration->serverKey,
                            'Content-Type: application/json',
                            'priority:high',
                        ];

                        $result = CurlRequest::curlPostContent('https://fcm.googleapis.com/fcm/send', $dataString, $headers);

                        if (@$result->results[0]->error) {
                            $this->createErrorLog('Push Notification Error: ' . $result->results[0]->error);
                            session()->flash('push_notification_error', $result->results[0]->error);
                        } else {
                            $userNotification              = new UserNotification();
                            $userNotification->title       = $subject;
                            $userNotification->user_id     = $this->user->id;
                            $userNotification->remark      = $remark;
                            $userNotification->click_value = $clickValue;
                            $userNotification->save();

                            $this->createLog('push_notification');
                        }
                        // curl_close($ch);
                    }
                }
            } catch (\Exception$e) {
                $this->createErrorLog('Push Notification Error: ' . $e->getMessage());
                session()->flash('push_notification_error', $e->getMessage());
            }
        }
    }

    /**
     * Configure some properties
     *
     * @return void
     */
    public function prevConfiguration() {
        if ($this->user) {
            $this->deviceTokens = $this->user->deviceTokens()->pluck('token')->toArray();
            $this->receiverName = $this->user->fullname;
        }
        $this->toAddress = $this->deviceTokens;
    }
}
